<?php


namespace BlueWeb\Log\Service;

use BlueWeb\Log\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Esc\User\Entity\User;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\Security\Core\Security;

class LogService
{
    private $entityManagerInterface;
    private $security;
    private $codeGroup = null;

    public function __construct(
        EntityManagerInterface $manager,
        Security               $security
    )
    {
        $this->entityManagerInterface = $manager;
        $this->security = $security;
    }

    /**
     * Genera un code Group
     * @return void
     */
    public function initializeCodeGroup(): void
    {
        $this->codeGroup = uniqid(null,false);
    }

    /**
     * Creo una riga di log
     *
     * @param string $username
     * @param string|null $nominative
     * @param string $activityName
     * @param string $section
     * @param string $action
     * @param string $description
     * @param AttributeBag $attributeBag
     */
    public function createLog(string $username, ?string $nominative, string $activityName, string $section, string $action, string $description, AttributeBag $attributeBag): void
    {

        $log = new Log();

        $log->setUsername($username);
        $log->setNominative($nominative);
        $log->setActivityName($activityName);
        $log->setSection($section);
        $log->setAction($action);
        $log->setDescription($description);
        $log->setData($attributeBag->all());
        $log->setCodeGroup($this->codeGroup);

        $this->entityManagerInterface->persist($log);
        $this->entityManagerInterface->flush();

    }

    /**
     * Creo una riga di log semplice
     *
     * @param string $activityName
     * @param string $section
     * @param string $action
     * @param string $description
     * @param AttributeBag $attributeBag
     */
    public function createLogSimple(string $activityName, string $section, string $action, string $description, AttributeBag $attributeBag): void
    {

        /** @var User $user */
        $user = $this->security->getUser();

        $log = new Log();

        $log->setUsername($user->getUsername());
        $log->setNominative($user->getFullname());
        $log->setActivityName($activityName);
        $log->setSection($section);
        $log->setAction($action);
        $log->setDescription($description);
        $log->setData($attributeBag->all());
        $log->setCodeGroup($this->codeGroup);

        $this->entityManagerInterface->persist($log);
        $this->entityManagerInterface->flush();

    }


}
