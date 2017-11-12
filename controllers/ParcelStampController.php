<?php

namespace app\controllers;

use app\models\User;
use webvimark\components\AdminDefaultController;
use Yii;
use app\models\ParcelStamp;
use app\models\search\ParcelStampSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ParcelStampController implements the CRUD actions for ParcelStamp model.
 */
class ParcelStampController extends AdminDefaultController
{
    /**
     * Lists all ParcelStamp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParcelStampSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'all_service'   => Yii::$app->params['all_service'],
            'all_status'    => ParcelStamp::getStatus(),
        ]);
    }

    /**
     * Displays a single ParcelStamp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'all_service'   => Yii::$app->params['all_service'],
            'all_status'    => ParcelStamp::getStatus(),
        ]);
    }

    /**
     * Creates a new ParcelStamp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ParcelStamp();
        $request = Yii::$app->request;

        $model->user_id = User::getBusinessId($request->post('user_id',false));
        $model->status = $request->post('status', ParcelStamp::ACCEPTED);
        $model->created_at = time();
        $model->created_by = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ParcelStamp model.
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
            return $this->renderIsAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ParcelStamp model.
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
        $model->status = $model::BLOCKED;
        if(!$model->save()){
            Yii::$app->getSession()->setFlash('warning', 'Thao tác xóa sản phẩm chưa thành công. Vui lòng thử lại !');
        }else{
            Yii::$app->getSession()->setFlash('success', 'Xóa lô tem thành công !');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the ParcelStamp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParcelStamp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $query = ParcelStamp::find()->where(['id'=>$id]);
        if(!Yii::$app->user->isAdminGroup){
            $query->andWhere(['user_id'=>User::getBusinessId()])
                    ->andWhere(['!=','status',ParcelStamp::BLOCKED]);
        }
//        if (($model = ParcelStamp::findOne($id)) !== null) {
        if ( ($model = $query->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
