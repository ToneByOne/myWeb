<?php
/**
 * 我的博客控制器
 * Created by PhpStorm.
 * User: Administrator（tangjf）
 * Date: 15-3-3
 * Time: 下午4:46
 *
 */
/**
 * 我的博客控制器
 * Class MyblogController
 * @author tangjf 2015-3-3
 */
class MyblogController extends Controller
{
    //修改layout
    public $layout = 'main_blog';

    /**
     * 首页（默认）
     * @author tangjf 2015-3-3
     *
     */
    public function actionIndex()
    {
        $data = ContentService::factory()->getContent(null);;
        $this->render('index', array('data' => $data));
    }

    /**
     * 关于我
     * @author tangjf 2015-3-3
     */
    public function actionAbout()
    {
        $this->render('about');
    }

    /**
     * 生活
     * @author tangjf 2015-3-3
     */
    public function actionLive()
    {
        $this->render('live');
    }

    /**
     * 分享
     * @auhto tangjf 2015-3-3
     */
    public function actionShare()
    {
        $this->render('share');
    }

    /**
     *留言板
     * @author tangjf 2015-3-3
     */
    public function actionMessage()
    {
        $this->render('message');
    }

    /**
     *发布文章
     */
    public function actionPublish()
    {
        $model = new PublishForm();
        //表单验证
        if (isset($_POST['ajax']) && $_POST['ajax'] === $model) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $cid = Yii::app()->request->getParam('cid');
        //处理表单数据
        if ($_POST['PublishForm']) {

            $model->attributes = $_POST['PublishForm'];
            $file = CUploadedFile::getInstance($model, 'coverImage');
            var_dump($file);exit;
            $modelArgs = $this->handleForm($model);
            //创建多级目录
            $pathDir = CT::IMAGEPATH . time();
            ContentService::factory()->mkdirs($pathDir);
            $path = "/" . $pathDir . '/' . $file->name;
            if (!empty($file)) {
                $modelArgs['coverImage'] = $file->name;
                $modelArgs['url'] = Yii::app()->request->hostInfo . $path;
            }

            $id = $cid ? ContentService::factory()->update($modelArgs) : ContentService::factory()->save($modelArgs);

            if ($id) {
                $imagePath = Yii::getPathOfAlias('webroot') . $path;
                $file->saveAs($imagePath);
                $this->redirect($this->createUrl('/'));
            }
            Yii::app()->end();
        }
        if ($cid) {
            $content = ContentService::factory()->getContent(array('id' => $cid));
            $model->title = $content[0]->fdTitle;
            $model->intro = $content[0]->fdIntro;
            $model->coverImage = $content[0]->fdImage;
            $model->type = $content[0]->fdTypeID;
            $model->text = $content[0]->fdContent;
        }
        $this->render('publish', array('model' => $model));
    }

    /**
     * 处理表单数据，返回二维数组
     *
     */
    protected function handleForm($model)
    {
        return array(
            'authorID' => 1,
            'typeID' => $model->type,
            'title' => $model->title,
            'intro' => $model->intro,
            'content' => $model->text
        );
    }

    /**
     * 处理表单数据
     */
//    public function action
    /**
     * test
     */
    public function actionTest()
    {
        $this->render('upload');
    }
}