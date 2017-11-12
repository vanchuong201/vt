<?php

namespace app\controllers;

use app\helpers\CodeHelper;
use app\models\logs\LogsStatus;
use app\models\ParcelStamp;
use app\models\search\StampsSearch;
use app\models\Stamps;
use app\models\User;
use webvimark\components\AdminDefaultController;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;

/**
 * StampsController implements the CRUD actions for Stamps model.
 */
class StampsController extends AdminDefaultController
{

    public function beforeAction($action)
    {
        $user_id = Yii::$app->request->get('u',null);
        Stamps::$user_id = ($user_id && Yii::$app->user->isAdminGroup) ? $user_id : User::getBusinessId();
        if(!Stamps::tableName()){ // Chưa có bảng tem
            if(!Yii::$app->user->isAdminGroup){
                Yii::$app->getSession()->setFlash('warning', 'Doanh nghiệp của bạn chưa có tem, Hãy bắt đầu bằng cách tạo lô tem ở đây !');
            }
            $this->redirect(['/parcel-stamp/index']);
            return false;
        }
        if ( parent::beforeAction($action) )
        {
            if ( $this->enableOnlyActions !== [] AND in_array($action->id, $this->_implementedActions) AND !in_array($action->id, $this->enableOnlyActions) )
            {
                throw new NotFoundHttpException('Page not found');
            }

            if ( in_array($action->id, $this->disabledActions) )
            {
                throw new NotFoundHttpException('Page not found');
            }

            return true;
        }

        return false;
    }

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

    public function actionChongGia()
    {
        echo time();
        echo date('H:i:s d/m/Y',1510516147);
        $searchModel = new StampsSearch();
        $dataProvider = $searchModel->searchCg(Yii::$app->request->queryParams);

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
            $parcel = $request->post('parcel');
            $start = $request->post('start');
            $end = $request->post('end');
            $list = $request->post('list');
            $product_id = $request->post('product_id');


            $value = ['status'=>Stamps::ACTIVE_FOR_RELEASE, 'product_id'=>$product_id];
            if($type === Stamps::ACTIVE_BY_PARCEL){
                if(empty($parcel)){
                    Yii::$app->getSession()->setFlash('warning', 'Bạn chưa chọn lô tem !');
                }else{
                    $count = Stamps::activeStamps($value, ['parcel_id'=>$parcel]);
                }
            }
            elseif ($type === Stamps::ACTIVE_BY_BATCH){
                if(empty($start) && empty($end)){
                    Yii::$app->getSession()->setFlash('warning', 'Bạn chưa nhập đủ serial đầu, cuối !');
                }else{
                    $start = CodeHelper::endCodeSerial($start);
                    $end = CodeHelper::endCodeSerial($end);
                    $count = Stamps::activeStamps($value, ['and',['>=', 'id', $start['id']],['<=', 'id', $end['id']], ]);
                }
            }
            elseif ($type === Stamps::ACTIVE_BY_LIST){
                if(empty($list)){
                    Yii::$app->getSession()->setFlash('warning', 'Bạn chưa nhập đủ serial đầu, cuối !');
                }else{
                    $list = explode(',', $list);
                    $list_id = [];
                    foreach ($list as $serial){
                        $list_id[] = CodeHelper::endCodeSerial($serial)['id'];
                    }
                    $count = Stamps::activeStamps($value, ['id'=>$list_id]);
                }
            }
            else{
                Yii::$app->getSession()->setFlash('warning', 'Bạn chưa chọn kiểu kích hoạt !');
            }

            if(isset($count)){
                if( is_int($count) && $count>=0 ){
                    $parcel ? $logs['parcel_id']=(int)$parcel : null;
                    $start ? $logs['code_start']=$start['id'] : null;
                    $end ? $logs['code_end']=$end['id'] : null;
                    $logs['status']=Stamps::ACTIVE_FOR_RELEASE;
                    $logs['product_id']=(int)$product_id;
                    $logs['user_id'] = User::getBusinessId();
                    $logs['updated_by'] = Yii::$app->user->id;
                    $logs['created_at'] = time();
                    LogsStatus::writeLogs($logs);

                    Yii::$app->getSession()->setFlash('success', "Kích hoạt thành công! <br> Số lượng: $count tem được cập nhật");
//                    Yii::$app->getSession()->setFlash('success', "Kích hoạt thành công!");
                }else{
                    Yii::$app->getSession()->setFlash('warning', 'Kích hoạt không thành công. Vui lòng thử lại');
                }
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
        if(!Yii::$app->user->isAdminGroup){
            return $this->redirect('index');
        }
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
        if(!Yii::$app->user->isAdminGroup){
            return $this->redirect('index');
        }

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
        if(!Yii::$app->user->isAdminGroup){
            return $this->redirect('index');
        }

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
        if(!Yii::$app->user->isAdminGroup){
            return $this->redirect('index');
        }

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
