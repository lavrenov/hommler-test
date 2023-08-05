<?php

namespace app\controllers;

use app\models\Product;
use app\models\ProductSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
				'access' => [
					'class' => AccessControl::class,
					'rules' => [
						[
							'allow' => true,
							'roles' => ['@'],
						],
					],
				],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

	/**
	 * @return Response
	 */
	public function actionColumnSet()
	{
		if ($this->request->isPost) {
			$columnSet = $this->request->post('columnSet');
			$columnSet = is_array($columnSet) ? implode(',', $columnSet) : '';
			Yii::$app->response->cookies->add(new Cookie([
				'name' => 'columnSet',
				'value' => $columnSet,
			]));
		}

		return $this->redirect(['index']);
	}

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
		$columnSet = Yii::$app->request->cookies->getValue('columnSet', 'image,sku,name,stock_units,type');
		$columnSet = $columnSet ? explode(',', $columnSet) : [];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'columnSet' => $columnSet,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->validate()) {
				$model->upload = UploadedFile::getInstance($model, 'image');
				if ($name = $model->uploadImage()) {
					$model->image = $name;
				}
				$model->save();

				return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$oldImage = $model->image;

        if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->validate()) {
				$model->upload = UploadedFile::getInstance($model, 'image');
				if ($newImage = $model->uploadImage()) {
					if (!empty($oldImage)) {
						$model::removeImage($oldImage);
					}
					$model->image = $newImage;
				} else {
					if ($model->removeImage) {
						$model::removeImage($oldImage);
						$oldImage = '';
					}
					$model->image = $oldImage;
				}
				$model->save();

				return $this->redirect(['index']);
			}
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
		if ($this->request->isPost) {
			$id = $this->request->post('id');
			if (is_array($id)) {
				foreach ($id as $item) {
					$this->findModel($item)->delete();
				}
			} else {
				$this->findModel($id)->delete();
			}
		}

		return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
