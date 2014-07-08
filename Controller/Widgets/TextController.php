<?php
namespace Arnm\ContentBundle\Controller\Widgets;

use Symfony\Component\Form\FormError;

use Arnm\WidgetBundle\Entity\Param;
use Arnm\ContentBundle\Model\TextWidget;
use Arnm\ContentBundle\Form\TextType;
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
class TextController extends ArnmWidgetController
{

    /**
     * {@inheritdoc}
     */
    public function renderAction(Widget $widget)
    {
        $textParam = $widget->getParamByName('text');

        return $this->render('ArnmContentBundle:Widgets\Text:render.html.twig', array(
            'text' => $textParam
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function editAction()
    {
        $form = $this->createForm(new TextType());

        return $this->render('ArnmContentBundle:Widgets\Text:edit.html.twig', array(
            'edit_form' => $form->createView()
        ));
    }

    /**
     * {@inheritdoc}
     * @see Arnm\WidgetBundle\Controllers.ArnmWidgetController::getConfigFields()
     */
    public function getConfigFields()
    {
        return array('text');
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

        $textObj = new TextWidget();
        $this->fillDataObject($widget, $textObj);
        $form = $this->createForm(new TextType(), $textObj);

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

        $this->processSaveParam($widget, $textObj);

        return $this->createResponse(array('OK'));
    }

    /**
     * Creates new of updates existing param of the widget
     *
     * @param Widget $widget
     * @param TextWidget $textObj
     */
    protected function processSaveParam(Widget $widget, TextWidget $textObj)
    {
        //find the widget
        $param = $widget->getParamByName('text');
        $em = $this->getEntityManager();
        if ($param instanceof Param) {
            //update existing
            $param->setValue((string) $textObj->getText());
        } else {
            //create new
            $param = new Param();
            $param->setName('text');
            $param->setValue((string) $textObj->getText());
            $param->setWidget($widget);
        }

        $em->persist($param);
        $em->flush();
    }

    /**
     * Fill the object with a data from widget if available
     *
     * @param Widget $widget
     * @param TextWidget $textObj
     */
    protected function fillDataObject(Widget $widget, TextWidget $textObj)
    {
        $param = $widget->getParamByName('text');
        if ($param instanceof Param) {
            $textObj->setText($param->getValue());
        }
    }
}
