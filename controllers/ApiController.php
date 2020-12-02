<?php

namespace app\controllers;

use app\models\User;
use http\Exception\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;

/**
 * Class ApiController
 * @package app\controllers
 */
class ApiController extends Controller
{
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        try {
            $result = [
                'status' => self::STATUS_SUCCESS,
            ];

            $request = \Yii::$app->request;
            if (!$request->isPost) {
                throw new MethodNotAllowedHttpException('Method Not Allowed. This URL can only handle the following request methods: POST.');
            }

            // step 1 log
            \Yii::$app->requestLogger->log($request->getRawBody());

            // step 2 validate and process data
            $requestData = $request->getBodyParams();
            $userModel = !empty($requestData['email']) ? User::findOne(['email' => $requestData['email']]) : null;
            if (!$userModel) {
                $userModel = new User();
            }
            $userModel->setAttributes($requestData);

            if (!$userModel->save()) {
                throw new InvalidArgumentException(implode(', ', $userModel->getErrorSummary(false)), 405);
            }

            // step 3 prepare answer
            $result['data'] = User::find()
                ->where(['>', 'id', 3])
                ->andWhere(['not like', 'email',  '%' .'test' . '%', false])
                ->orderBy('name ASC')
                ->all();

            return $this->asJson($result);
        } catch (\Throwable $e) {
            return $this->asJson([
                'status' => self::STATUS_ERROR,
                'message' => $e->getMessage(),
            ])->setStatusCodeByException($e);
        }
    }
}