<?php

namespace app\controllers\admin;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\UploadFiles;
use app\models\tables\Files;
use app\models\tables\Products;
use app\models\tables\Categories;
use app\models\tables\ProductsCategories;
use app\models\tables\ProductsFiles;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    const MAX_FILES = 5;

    private function saveCategories(Products $product, array $categories) {
        $newCategories = Categories::findAll($categories);
        foreach($newCategories as $category) {
            $productsCategories = new ProductsCategories();
            $productsCategories->product_id = $product->id;
            $productsCategories->category_id = $category->id;
            $productsCategories->save();
        }
    }
    
    private function saveFiles(Products $product, UploadFiles $uploadedFile) {
        if ($uploadedFile->validate()) {
            foreach($uploadedFile->files as $value) {
                $file =  new Files();
                $file->name = $value->name;
                $file->type = $value->type;
                $file->size = $value->size;
                $file->blob = file_get_contents(
                    $value->tempName
                );
                $file->save();
                $productsFiles = new ProductsFiles();
                $productsFiles->file_id = $file->id;
                $productsFiles->product_id = $product->id;
                $productsFiles->save();
            }
        }
    }

    private function deleteFile($file_id) {
        return Files::findOne($file_id)->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'delete-file'],
                        'roles' => ['admin', 'manager'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Products::find(),
            'pagination' => array('pageSize' => 5),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        $uploadFiles = new UploadFiles();
        $categories = new Categories();
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $model->save();
            $uploadFiles->files = UploadedFile::getInstances($uploadFiles, 'files');
            $this->saveCategories($model, $post["Categories"]["id"]);
            $this->saveFiles($model, $uploadFiles);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'uploadFiles' => $uploadFiles,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categories = new Categories();
        $countFiles = count($model->productsFiles);
        $post = Yii::$app->request->post();
        if($countFiles) {
            $uploadFiles = $countFiles === self::MAX_FILES 
                ? false : new UploadFiles(self::MAX_FILES - $countFiles, true);
        } else {
            $uploadFiles = new UploadFiles();
        }

        if ($model->load($post) && $model->save()) {
            ProductsCategories::deleteAll(['product_id' => $model->id]);
            $this->saveCategories($model, $post["Categories"]["id"]);
            if($uploadFiles !== false) {
                $uploadFiles->files = UploadedFile::getInstances($uploadFiles, 'files');
                $this->saveFiles($model, $uploadFiles);
            }
            return $this->redirect(['view', 'id' => $model->id]);
            return;
        }

        return $this->render('update', [
            'model' => $model,
            'uploadFiles' => isset($uploadFiles) ? $uploadFiles : false,
            'categories' => $categories,
        ]);
    }

    public function actionDeleteFile($id, $file)
    {
        $this->deleteFile($file);
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $filesProducts = ArrayHelper::toArray($model->productsFiles);
        foreach($model->productsFiles as $item) {
            $this->deleteFile($item->file_id);
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
