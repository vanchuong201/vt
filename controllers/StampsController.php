<?php

namespace app\controllers;

use app\helpers\CodeHelper;
use app\models\ParcelStamp;
use app\models\searchs\StampsSearch;
use app\models\Stamps;
use app\models\User;
use webvimark\components\AdminDefaultController;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * StampsController implements the CRUD actions for Stamps model.
 */
class StampsController extends AdminDefaultController
{

    /**
     * Lists all Stamps models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StampsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'all_status' => Stamps::getStatus(),
            'all_service' => Yii::$app->params['all_service'],
        ]);
    }

    public function actionActive()
    {
        $request = Yii::$app->request;
        if($request->isPost){
            $type = $request->post('type_active',0);
            $parcel = $request->post('parcel',0);
            $start = $request->post('start',0);
            $end = $request->post('end',0);
            $list = $request->post('list',0);

            if($type == Stamps::ACTIVE_BY_PARCEL){
                if(empty($parcel)){
                    Yii::$app->getSession()->setFlash('warning', 'Bạn chưa chọn lô tem !');
                }else{
                    Stamps::activeStamps($type, $parcel);
                }
            }

            elseif ($type == Stamps::ACTIVE_BY_BATCH){
                if(empty($start) && empty($end)){
                    Yii::$app->getSession()->setFlash('warning', 'Bạn chưa nhập đủ serial đầu, cuối !');
                }else{
                    $start = CodeHelper::endCodeSerial($start);
                    $end = CodeHelper::endCodeSerial($end);
                    Stamps::activeStamps($type, [$start['id'],$end['id']]);
                }
            }

            elseif ($type == Stamps::ACTIVE_BY_LIST){
                if(empty($list)){
                    Yii::$app->getSession()->setFlash('warning', 'Bạn chưa nhập đủ serial đầu, cuối !');
                }else{
                    $list = explode(',', $list);
                    $list_id = [];
                    foreach ($list as $serial){
                        $list_id[] = CodeHelper::endCodeSerial($serial)['id'];
                    }
                    Stamps::activeStamps($type, $list_id);
                }
            }

            else{
                Yii::$app->getSession()->setFlash('warning', 'Bạn chưa chọn kiểu kích hoạt !');
            }


            return $this->redirect(['active']);
        }

        $parcel_q = ParcelStamp::find()->select(['id','name'])->where(['status'=>ParcelStamp::GEN_SUCCESS]);
        if(!Yii::$app->user->isAdminGroup){
            $parcel_q->andWhere(['user_id'=>User::getBusinessId()]);
        }
        $all_parcel = $parcel_q->all();
        return $this->render('active', [
            'all_parcel'=>$all_parcel,
        ]);
    }


    /**
     * Displays a single Stamps model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Stamps model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Stamps();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Stamps model.
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
            ]);
        }
    }

    /**
     * Deletes an existing Stamps model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stamps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stamps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stamps::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
