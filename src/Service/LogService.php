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
    private $action = null;
    private $section = null;
    private $activityName = null;
    private $username = null;
    private $nominative = null;

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
        $this->codeGroup = uniqid(null, false);
    }

    /**
     * Setta l\'action
     * @param string $action
     * @return void
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * Setta la section
     * @param string $section
     * @return void
     */
    public function setSection(string $section): void
    {
        $this->section = $section;
    }

    /**
     * Setta la username
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Setta il nominativo
     * @param string $nominative
     * @return void
     */
    public function setNominative(string $nominative): void
    {
        $this->nominative = $nominative;
    }

    /**
     * Setta la activity name
     * @param string $activityName
     * @return void
     */
    public function setActivityName(string $activityName): void
    {
        $this->activityName = $activityName;
    }


    /**
     * Set auto user
     * @return void
     */
    public function setAutoUsernameAndNominative(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $this->username = $user->getUsername();
        $this->nominative = $user->getName() . ' '. $user->getSurname();
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

        $this->save($log);

    }

    /**
     * Creo una riga di log
     *
     * @param string $description
     * @param AttributeBag $attributeBag
     */
    public function create(string $description, AttributeBag $attributeBag): void
    {

        $log = new Log();

        $log->setUsername($this->username);
        $log->setNominative($this->nominative);
        $log->setActivityName($this->activityName);
        $log->setSection($this->section);
        $log->setAction($this->action);
        $log->setDescription($description);
        $log->setData($attributeBag->all());
        $log->setCodeGroup($this->codeGroup);

        $this->save($log);

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

        $this->save($log);

    }

    /**
     * @param Log $log
     * @return void
     */
    private function save(Log $log): void
    {
        $this->entityManagerInterface->persist($log);
        $this->entityManagerInterface->flush();
    }


}
