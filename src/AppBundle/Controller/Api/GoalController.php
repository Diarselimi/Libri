<?php
/**
 * Created by PhpStorm.
 * User: diar
 * Date: 11/30/16
 * Time: 2:42 AM
 */

namespace AppBundle\Controller\Api;


use AppBundle\Controller\BaseController;
use AppBundle\Entity\Goal;
use AppBundle\Form\GoalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class GoalController extends BaseController
{

    /**
     * @param Request $request
     * @Route("/goal/create", name="create_new_goal")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $goal = $em->getRepository(Goal::class)->findCurrentGoal();
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if($form->isValid()){
            $goal = $form->getData();
            $goal->setUser($this->getUser());
            $em->persist($goal);
            $em->flush();

            return $this->createApiResponse($goal);
        }

        return $this->createApiResponse([
            'message' => 'Something went wrong !'
        ]);
    }

    //TODO: update the goal

    //TODO: delete the goal

}