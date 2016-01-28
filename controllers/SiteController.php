<?php

namespace app\controllers;

use app\models\Album;
use app\models\Photos;
use app\models\User;
use Yii;
use yii\authclient\clients\VKontakte;
use yii\authclient\OAuthToken;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\StringHelper;
/**
 * qwe
 * @property VKontakte _vkObject
*/

class SiteController extends Controller
{
    const VK_GROUP_ID = 73439358;
    private $_vkObject;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ]
        ];
    }

    /**
     * @param $vk VK
     * @return Response
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function onAuthSuccess($vk)
    {
        /** @var $this->_vkObject VKontakte */
        $attributes = $this->_vkObject->getUserAttributes();

        $user = User::findOne(['id' => 1]);
        $user->token = $this->_vkObject->getAccessToken()->token;
        return $user->save();
    }

    public function actionIndex()
    {
        $albums = Album::find()
            ->select(['*'])
            ->joinWith($this->_getClassBaseName(new Photos()))
            ->where(['main_photo' => 1])
            ->asArray()
            ->all();
        return $this->render('albums', compact('albums'));
    }

    public function actionView($id)
    {
        $photos = Photos::findAll(['album_id' => $id]);
        return $this->render('view', compact('photos'));
    }

    public function actionVk()
    {
        exit('WARNING EXIT');
        echo '<pre>';
        $this->_vkObject = Yii::$app->authClientCollection->getClient('vkontakte');
        if ($this->_makeOAuth()) {
            $response = $this->_createAlbum();
            $this->_createAlbumPhoto($response['albumData'], $response['albumThumbs']);
        }
    }

    private function _createAlbum()
    {
        $albumData = [];
        $albumThumbs = [];
        $data = $this->_vkObject->api('photos.getAlbums', 'GET', ['owner_id' => '-'.self::VK_GROUP_ID]);
        if(isset($data, $data['response'], $data['response'][0])) {
            foreach ($data['response'] as $response) {
                $albumThumbs[] = (int)$response['thumb_id'];
                $albumData[] = [
                    'album_id' => $response['aid'],
                    'title' => $response['title'],
                    'description' => $response['description'],
                    'vk_created' => (int)$response['created'],
                    'vk_updated' => (int)$response['updated'],
                    'created_at' => time(),
                    'updated_at' => time(),
                ];
            }
            if($albumData && $albumData[0]) {
                Yii::$app->db->createCommand('TRUNCATE `'.$this->_getClassBaseName(new Photos()).'`')->execute();
                Yii::$app->db->createCommand('TRUNCATE `'.$this->_getClassBaseName(new Album()).'`')->execute();
                Yii::$app->db->createCommand()->batchInsert(Album::tableName(), array_keys($albumData[0]), $albumData)->execute();
            }
        }
        return [
            'albumData' => $albumData,
            'albumThumbs' => $albumThumbs,
        ];
    }

    private function _getClassBaseName($model)
    {
        return strtolower(StringHelper::basename(get_class($model)));
    }

    private function _createAlbumPhoto(array $albums, array $albumThumbs)
    {
        $photoData = [];
        $data = [];
        foreach ($albums as $key => $album) {
            sleep(1);
            $data = $this->_vkObject->api(
                'photos.get',
                'GET',
                [
                    'owner_id' => '-'.self::VK_GROUP_ID,
                    'album_id' => $album['album_id'],
                    'rev' => 0,
                    'extended' => 0,
                ]
            );
            if(isset($data, $data['response'], $data['response'][0])) {
                $photoData = [];
                foreach ($data['response'] as $response) {
                    $pname = $album['title'].'_'.$album['description'].'_'.$response['text'];
                    $pname = 'krasotka_me_'.self::_get_in_translate_to_en($pname).'_'.$response['pid'];
                    $pname = preg_replace('/(\.|\/|<.*>| )/', '_', $pname);
                    $mainPhoto = 0;
                    if ($albumThumbs[$key] == $response['pid']) {
                        $mainPhoto = 1;
                    }
                    $photoData[] = [
                        'album_id' => $response['aid'],
                        'photo_id' => $response['pid'],
                        'vk_photo' => isset($response['src_xbig']) ? $response['src_xbig'] : $response['src_big'],
                        'photo_name' => $pname.'.jpg',
                        'text' => $response['text'],
                        'vk_created' => (int)$response['created'],
                        'main_photo' => $mainPhoto,
                        'created_at' => time(),
                        'updated_at' => time(),
                    ];
                }
                if($photoData && $photoData[0]) {
                    $isInsert = Yii::$app->db->createCommand()->batchInsert(
                        Photos::tableName(),
                        array_keys($photoData[0]),
                        $photoData
                    )->execute();
                    if ($isInsert) {
                        foreach ($photoData as $p_data) {
                            $path = Yii::getAlias('@fullMediaDir/'.$p_data['album_id'].'/'.$p_data['photo_name']);
                            if(!is_dir(dirname($path))) {
                                mkdir(dirname($path), 0777, true);
                            }
                            $image = file_get_contents($p_data['vk_photo']);
                            file_put_contents($path, $image);
                        }
                    }
                }
            }
        }
        var_dump($data);
        exit;
    }

    /** @var $vk VKontakte */
    private function _makeOAuth()
    {
        if($this->_vkObject) {
            $oAuthToken = new OAuthToken();
            if (isset($_GET['code']) && !$this->_vkObject->getAccessToken()) {
                $oAuthToken = $this->_vkObject->fetchAccessToken($_GET['code']);
                $this->onAuthSuccess($this->_vkObject);
            } else {
                if (!$this->_vkObject->getAccessToken()) {
                    $token = User::findOne(['id' => 1])->token;
                    if ($oAuthToken->isExpired) {
                        $this->_vkObject->refreshAccessToken($token);
                    } else {
                        $oAuthToken->setToken($token);
                        $this->_vkObject->setAccessToken($oAuthToken);
                    }

                }
                if (!$this->_vkObject->getAccessToken()) {
                    $response = $this->_vkObject->buildAuthUrl();
                    return Yii::$app->controller->redirect($response);
                }
            }
            return true;
        }

        return false;
    }

    private static function _get_in_translate_to_en($string, $gost=false)
    {
        if($gost)
        {
            $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
                "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
                "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
                "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"");
        }
        else
        {
            $arStrES = array("ае","уе","ое","ые","ие","эе","яе","юе","ёе","ее","ье","ъе","ый","ий");
            $arStrOS = array("аё","уё","оё","ыё","иё","эё","яё","юё","ёё","её","ьё","ъё","ый","ий");
            $arStrRS = array("а$","у$","о$","ы$","и$","э$","я$","ю$","ё$","е$","ь$","ъ$","@","@");

            $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                "Е"=>"Ye","е"=>"e","Ё"=>"Ye","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                "Й"=>"Y","й"=>"y","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n",
                "О"=>"O","о"=>"o","П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t",
                "У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f","Х"=>"Kh","х"=>"kh","Ц"=>"Ts","ц"=>"ts","Ч"=>"Ch","ч"=>"ch",
                "Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch","Ъ"=>"","ъ"=>"","Ы"=>"Y","ы"=>"y","Ь"=>"","ь"=>"",
                "Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","@"=>"y","$"=>"ye");

            $string = str_replace($arStrES, $arStrRS, $string);
            $string = str_replace($arStrOS, $arStrRS, $string);
        }

        return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
