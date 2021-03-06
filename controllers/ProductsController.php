<?php

namespace app\controllers;

use app\components\AdminDefaultController;
use app\models\User;
use Yii;
use app\models\Products;
use app\models\search\ProductsSearch;
use yii\web\NotFoundHttpException;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends AdminDefaultController
{

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'all_status' => Products::getStatus(),
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'all_status' => Products::getStatus(),
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
        if(!Yii::$app->user->isAdminGroup){
            $model->status = Products::PRODUCT_ACTIVE;
            $model->user_id = User::getBusinessId();
        }
        $model->created_at = time();
        $model->created_by = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'all_status' => Products::getStatus(),
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'all_status' => Products::getStatus(),
            ]);
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);

        $model = $this->findModel($id);
        $model->status = $model::PRODUCT_DELETED;
        if(!$model->save()){
            Yii::$app->getSession()->setFlash('warning', 'Thao tác xóa sản phẩm chưa thành công. Vui lòng thử lại !');
        }else{
            Yii::$app->getSession()->setFlash('success', 'Xóa sản phẩm thành công !');
        }
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
//        if (($model = Products::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }

        $query = Products::find()->where(['id'=>$id]);
        if(!Yii::$app->user->isAdminGroup){
            $query->andWhere(['user_id'=>User::getBusinessId()])
                ->andWhere(['!=','status',Products::PRODUCT_DELETED]);
        }
//        if (($model = ParcelStamp::findOne($id)) !== null) {
        if ( ($model = $query->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }
}
