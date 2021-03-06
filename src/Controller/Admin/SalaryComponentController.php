<?php

namespace KejawenLab\Application\SemartHris\Controller\Admin;

use KejawenLab\Application\SemartHris\Component\Salary\StateType;
use KejawenLab\Application\SemartHris\Repository\SalaryComponentRepository;
use KejawenLab\Application\SemartHris\Util\SettingUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
class SalaryComponentController extends AdminController
{
    /**
     * @Route("/salary-component", name="salary_component", options={"expose"=true})
     * @Method("GET")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function processAction(Request $request)
    {
        $this->denyAccessUnlessGranted(SettingUtil::get(SettingUtil::SECURITY_PAYROLL_MENU));

        return new JsonResponse(['components' => $this->container->get(SalaryComponentRepository::class)->findByState($request->query->get('state', StateType::STATE_PLUS))]);
    }
}
