<?php


namespace BlueWeb\Log\Service;

use App\Entity\Log;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LogService
{
    private $entityManagerInterface;
    private $security;
    private $normalizer;

    public function __construct(
        EntityManagerInterface $manager,
        Security               $security,
        NormalizerInterface    $normalizer
    )
    {
        $this->entityManagerInterface = $manager;
        $this->security = $security;
        $this->normalizer = $normalizer;
    }

    /**
     * Creo una riga di log
     *
     * @param string $username
     * @param string|null $nominative
     * @param string $section
     * @param string $action
     * @param string $description
     */
    public function createLog(string $username, ?string $nominative, string $section, string $action, string $description): void
    {

        $user = $this->security->getUser();

        $log = new Log();

        $log->setUsername($user->getUsername());
        $log->setNominative($nominative);
        $log->setSection($section);
        $log->setAction($action);
        $log->setDescription($description);

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

        $this->entityManagerInterface->persist($log);
        $this->entityManagerInterface->flush();

    }


}
