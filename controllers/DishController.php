<?php

namespace app\controllers;

use Yii;
use app\models\Dish;
use app\models\Ingridient;
use app\models\DishSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DishController implements the CRUD actions for Dish model.
 */
class DishController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Dish models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DishSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dish model.
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
     * Creates a new Dish model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dish();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $ingridients = Ingridient::find()->where(['status' => 1])->all();
            return $this->render('create', [
                'model' => $model,
                'ingridients' => $ingridients,
            ]);
        }
    }

    /**
     * Updates an existing Dish model.
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
            $ingridients = Ingridient::find()->where(['status' => 1])->all();
            return $this->render('update', [
                'model' => $model,
                'ingridients' => $ingridients,
            ]);
        }
    }

    /**
     * Deletes an existing Dish model.
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
     * Finds the Dish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dish::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionFind()
    {
        $result ='Ничего не найдено';
        $ids = Yii:: $app->request->post('string');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $resultArr = [];
        $arr = explode(',', $ids);
        foreach ($arr as $id) {
            $models = Dish::find()->where(['like', 'ingredients', ',' . $id . ','])->andWhere(['status' => 1])->all();
            if ($models) {
                foreach ($models as $model) {
                    if (in_array($model->id, $resultArr)) {
                        $resultArr[$model->id] = 1;
                    } else {
                        $resultArr[$model->id]++;
                    }
                }
            }
        }
        arsort($resultArr);
        $dishIds = [];
        foreach ($resultArr as $key => $item) {
            if ($item == count($arr)) {
                $dishIds[] = $key;
            }
            if ($item == 1) {
                unset($resultArr[$key]);
            }
        }
        if (count($dishIds) == 0) {
            foreach ($resultArr as $key=>$item) {
                $dishIds[] = $key;
            }
        }

        $models = Dish::find()->where(['in', 'id', $dishIds])->andWhere(['status' => 1])->all();
        if ($models) {
            $result = '';
            foreach ($models as $model) {
                $result = $result . $model->name . ', ';
            }
            $result = substr($result, 0, strlen($result)-2);
        }
        return ['result' => $result];
    }

}
