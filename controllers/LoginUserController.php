<?php

namespace app\controllers;

use Yii;
use app\models\LoginUser;
use app\models\LoginUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoginUserController implements the CRUD actions for LoginUser model.
 */
class LoginUserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all LoginUser models.
     * @return mixed
     */
    public function actionIndex() {
        //  return $this->render('index'); delete
        $searchModel = new LoginUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LoginUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LoginUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new LoginUser();

        $request = Yii::$app->request;

        if ($request->isPost) {

            $form = $request->post('LoginUser');

            $model->setAttributes([
                'email' => $form['email'],
                'firstname' => $form['firstname'],
                'lastname' => $form['lastname'],
            ]);

            $password = $form['password'];
            if ($password) {
                $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
                $model->setAttribute('password', $hash);
            }

            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LoginUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        $request = Yii::$app->request;

        if ($request->isPost) {

            $form = $request->post('LoginUser');

            $model->setAttributes([
                'email' => $form['email'],
                'firstname' => $form['firstname'],
                'lastname' => $form['lastname'],
            ]);

            $password = $form['password'];
            if ($password) {
                $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
                $model->setAttribute('password', $hash);
            }

            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LoginUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LoginUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoginUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LoginUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
