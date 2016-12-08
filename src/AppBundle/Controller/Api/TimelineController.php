<?php
namespace AppBundle\Controller\Api;


use AppBundle\Controller\BaseController;
use AppBundle\Entity\Timeline;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TimelineController extends BaseController
{
    /**
     * This function will return the timeline items
     * @Route("/timeline")
     * @Method(methods={"get"})
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $timeline =
            $em
            ->getRepository(Timeline::class)
            ->getAllAndOrderByLatest(
                $request->query->get('limit'),
                $request->query->get('offset')
            );

        if(!$timeline) {
            return new JsonResponse([], 400);
        }

        return $this->createApiResponse($timeline);
    }
}