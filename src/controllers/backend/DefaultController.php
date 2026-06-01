<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\controllers\backend;


use common\components\controller\ControllerTrait;
use DomainException;
use Besnovatyj\YandexMap\forms\backend\MapForm;
use Besnovatyj\YandexMap\forms\backend\search\MapSearch;
use Besnovatyj\YandexMap\repositories\MapRepository;
use Besnovatyj\YandexMap\services\YandexMapService;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\helpers\VarDumper;
use yii\web\Response;

class DefaultController extends \yii\web\Controller
{
    use ControllerTrait;

    private YandexMapService $service;
    private MapRepository $mapRepo;

    public function __construct($id, $module, YandexMapService $service, MapRepository $mapRepo, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->mapRepo = $mapRepo;
    }


    public function actionIndex(): string
    {
        $searchModel = new MapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'map' => $this->mapRepo->get($id),
        ]);
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $form = new MapForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $markerForms = Yii::$app->request->post('MarkerForm');
                if (is_array($markerForms)) {
                    $form->loadMarkerForms($markerForms);
                }
                $map = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Map successfully created');
                return $this->redirect(['view', 'id' => $map->id]);
            } catch (DomainException $e) {
                $this->handleDomainException($e, 'Ошибка');
            }
        }
        if ($form->hasErrors()) {
            $errors = $form->getErrorSummary(true);
            Yii::$app->session->addFlash('error', $errors);
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate(int $id): Response|string
    {
        $map = $this->mapRepo->get($id);
        $form = new MapForm($map);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $markerForms = Yii::$app->request->post('MarkerForm');
                if (is_array($markerForms)) {
                    $form->loadMarkerForms($markerForms);
                }
                $this->service->edit($map, $form);
                Yii::$app->session->setFlash('success', 'Map successfully updated');
                return $this->redirect(['view', 'id' => $map->id]);
            } catch (\Exception $e) {
                $this->handleDomainException($e, 'Ошибка');
            }
        }
        if ($form->hasErrors()) {
            $errors = $form->getErrorSummary(true);
            Yii::$app->session->addFlash('error', $errors);
        }
        return $this->render('update', [
            'model' => $form,
            'map' => $map,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        try {
            $this->service->remove($id);
            Yii::$app->session->setFlash('success', 'Map successfully deleted');
        } catch (\Exception $e) {
            Yii::$app->errorHandler->logException($e);
            if (YII_DEBUG) {
                Yii::$app->session->setFlash('error', VarDumper::dumpAsString($e->getMessage()));
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка');
            }
        }
        return $this->redirect(['index']);
    }

}
