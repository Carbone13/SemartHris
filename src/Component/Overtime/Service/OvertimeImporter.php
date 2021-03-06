<?php

namespace KejawenLab\Application\SemartHris\Component\Overtime\Service;

use KejawenLab\Application\SemartHris\Component\Employee\Repository\EmployeeRepositoryInterface;
use KejawenLab\Application\SemartHris\Component\Overtime\Model\OvertimeInterface;
use KejawenLab\Application\SemartHris\Component\Overtime\Repository\OvertimeRepositoryInterface;
use KejawenLab\Application\SemartHris\Util\SettingUtil;
use KejawenLab\Application\SemartHris\Util\StringUtil;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@kejawenlab.com>
 */
class OvertimeImporter
{
    /**
     * @var OvertimeCalculator
     */
    private $overtimeCalculator;

    /**
     * @var OvertimeRepositoryInterface
     */
    private $overtimeRepository;

    /**
     * @var EmployeeRepositoryInterface
     */
    private $employeeRepository;

    /**
     * @var string
     */
    private $overtimeClass;

    /**
     * @param OvertimeCalculator          $overtimeCalculator
     * @param OvertimeRepositoryInterface $overtimeRepository
     * @param EmployeeRepositoryInterface $employeeRepository
     * @param string                      $class
     */
    public function __construct(
        OvertimeCalculator $overtimeCalculator,
        OvertimeRepositoryInterface $overtimeRepository,
        EmployeeRepositoryInterface $employeeRepository,
        string $class
    ) {
        $this->overtimeCalculator = $overtimeCalculator;
        $this->overtimeRepository = $overtimeRepository;
        $this->employeeRepository = $employeeRepository;
        $this->overtimeClass = $class;
    }

    /**
     * @param \Iterator $overtimes
     *
     * @see uploads/templates/overtime.csv
     */
    public function import(\Iterator $overtimes): void
    {
        foreach ($overtimes as $overtime) {
            if (!(isset($overtime['employee_code']) || isset($overtime['date']))) {
                continue;
            }

            /* @var OvertimeInterface $object */
            if (!$employee = $this->employeeRepository->findByCode(StringUtil::sanitize($overtime['employee_code']))) {
                continue;
            }

            $overtimeDate = \DateTime::createFromFormat(SettingUtil::get(SettingUtil::DATE_FORMAT), StringUtil::sanitize($overtime['date']));
            $object = $this->overtimeRepository->findByEmployeeAndDate($employee, $overtimeDate);
            if (!$object) {
                $object = new $this->overtimeClass();
                $object->setOvertimeDate($overtimeDate);
                $object->setEmployee($employee);
            }

            if (!(isset($overtime['check_in']) && $overtime['check_in']) || !(isset($overtime['check_out']) && $overtime['check_out'])) {
                $object->setStartHour(\DateTime::createFromFormat('H:i', '00:00'));
                $object->setEndHour(\DateTime::createFromFormat('H:i', '00:00'));
            } else {
                $object->setStartHour(\DateTime::createFromFormat('H:i', StringUtil::sanitize($overtime['check_in'])));
                $object->setEndHour(\DateTime::createFromFormat('H:i', StringUtil::sanitize($overtime['check_out'])));
            }

            $this->overtimeRepository->update($object);
        }
    }
}
