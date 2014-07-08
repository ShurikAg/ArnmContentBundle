<?php
namespace Arnm\ContentBundle\Controller\Widgets;

use Symfony\Component\Form\FormError;

use Arnm\WidgetBundle\Entity\Param;

use Arnm\ContentBundle\Model\HtmlWidget;
use Arnm\ContentBundle\Form\HtmlType;
use Arnm\WidgetBundle\Entity\Widget;
use Arnm\WidgetBundle\Manager\WidgetsManager;
use Arnm\WidgetBundle\Controllers\ArnmWidgetController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
/**
 * Controller of text widget
 *
 * @author Alex Agulyansky <alex@iibspro.com>
 */
class HtmlController extends ArnmWidgetController
{

    /**
     * {@inheritdoc}
     */
    public function renderAction(Widget $widget)
    {
        $htmlParam = $widget->getParamByName('html');

        return $this->render('ArnmContentBundle:Widgets\Html:render.html.twig', array(
            'html' => $htmlParam
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function editAction()
    {
        $form = $this->createForm(new HtmlType());

        return $this->render('ArnmContentBundle:Widgets\Html:edit.html.twig', array(
            'edit_form' => $form->createView()
        ));
    }

    /**
     * {@inheritdoc}
     * @see Arnm\WidgetBundle\Controllers.ArnmWidgetController::getConfigFields()
     */
    public function getConfigFields()
    {
        return array(
            'html'
        );
    }

/**
     * {@inheritdoc}
     *
     * @see Arnm\WidgetBundle\Controllers.ArnmWidgetController::updateAction()
     */
    public function updateAction($id, Request $request)
    {
        $widget = $this->getWidgetManager()->findWidgetById($id);
        if (!($widget instanceof Widget)) {
            throw $this->createNotFoundException("Widget with id: '" . $id . "' not found!");
        }

        $htmlObj = new HtmlWidget();
        $this->fillDataObject($widget, $htmlObj);
        $form = $this->createForm(new HtmlType(), $htmlObj);

        $data = $this->extractArrayFromRequest($request);

        $form->bind($data);
        if (!$form->isValid()) {
            $response = array('error' => 'validation', 'errors' => array());
            $errors = $form->getErrors();
            foreach ($errors as $key => $error) {
                if ($error instanceof FormError) {
                    $response['errors'][$key] = $error->getMessage();
                }
            }

            return $this->createResponse($response);
        }

        $this->processSaveParam($widget, $htmlObj);

        return $this->createResponse(array('OK'));
    }

    /**
     * Creates new of updates existing param of the widget
     *
     * @param Widget $widget
     * @param HtmlWidget $textObj
     */
    protected function processSaveParam(Widget $widget, HtmlWidget $htmlObj)
    {
        //find the widget
        $param = $widget->getParamByName('html');
        $em = $this->getEntityManager();
        if ($param instanceof Param) {
            //update existing
            $param->setValue((string) $htmlObj->getHtml());
        } else {
            //create new
            $param = new Param();
            $param->setName('html');
            $param->setValue((string) $htmlObj->getHtml());
            $param->setWidget($widget);
        }

        $em->persist($param);
        $em->flush();
    }

    /**
     * Fill the object with a data from widget if available
     *
     * @param Widget $widget
     * @param HtmlWidget $htmlObj
     */
    protected function fillDataObject(Widget $widget, HtmlWidget $htmlObj)
    {
        $param = $widget->getParamByName('html');
        if ($param instanceof Param) {
            $htmlObj->setHtml($param->getValue());
        }
    }
}
