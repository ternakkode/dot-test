<?php
namespace App\Domain\Ticket\Application;

use App\Domain\Content\Entities\Page;
use App\Domain\Ticket\Entities\Ticket;
use App\Domain\Ticket\Repositories\InvitationRepository;
use App\Domain\Ticket\Repositories\TicketRepository;
use App\Domain\Ticket\Services\InvitationTicketService;
use App\Domain\UserManagement\Applications\UserApplication;
use App\Domain\UserManagement\Applications\UserManagerHandlerApplication;
use App\Supports\Models\DataType;
use Exception;

class TicketInvitationApplication
{
    private $ticketRepository;
    private $userManagerHandlerApplication;
    private $ticketAgentApplication;
    private $invitationApplication;
    private $invitationTicketService;
    private $invitationRepository;
    private $userApplication;
    public function __construct(
        InvitationTicketService $invitationTicketService,
        TicketRepository $ticketRepository,
        InvitationApplication $invitationApplication,
        TicketAgentApplication $ticketAgentApplication,
        UserManagerHandlerApplication $userManagerHandlerApplication,
        InvitationRepository $invitationRepository,
        UserApplication $userApplication
    ) {
        $this->invitationTicketService = $invitationTicketService;
        $this->invitationApplication = $invitationApplication;
        $this->ticketRepository = $ticketRepository;
        $this->userManagerHandlerApplication = $userManagerHandlerApplication;
        $this->ticketAgentApplication = $ticketAgentApplication;
        $this->invitationRepository = $invitationRepository;
        $this->userApplication = $userApplication;
    }
    public function verify($code, $fullname, $phone, $password, $type)
    {
        $ticket = $this->ticketRepository->findByCode($code);
        if (!$ticket) {
            throw (new Exception('Code not found'));
        }
        if ($ticket->role == DataType::PM) {
            $this->verifyReferalLandlord($ticket->id, $password);
        } elseif ($ticket->role  == DataType::TENANT) {
            $this->verifyTenant($ticket->id, $fullname, $phone, $password, $type);
        }
    }
    public function verifyTenant($ticketId, $fullname, $phone, $password, $type)
    {
        $invitation = $this->invitationRepository->findByTicketId($ticketId);
        $user = $this->userApplication->registerUser($invitation->email, $fullname, $phone, $password, $type, DataType::TENANT);
        return $this->invitationTenantVerified($ticketId, $user->id);
    }
    public function verifyReferalLandlord($ticketId, $password)
    {
        $invitation = $this->invitationRepository->findByTicketId($ticketId);
        $user = $this->userApplication->registerUser($invitation->email, $invitation->fullname, $invitation->phone, $password, $invitation->type, DataType::PM);
        return $this->invitationLandlordVerified($ticketId, $user->id);
    }
    public function createTicketInvitation($fullname, $email, $phone, $type, $role)
    {
        $ticketId = $this->createTicketAndGetIIdByRole($role);
        $this->invitationApplication->createInvitation($ticketId, $fullname, $email, $phone, $type);
    }
    public function invitationTenantVerified($ticketId, $userId)
    {
        $ticket = $this->ticketRepository->findById($ticketId);
        $isTicketTenant = $ticket->role ?? false;
        if (!$isTicketTenant) {
            throw (new Exception('Its not ticket tenant'));
        }
        $handlerId = $ticket->handled_by;
        return $this->userManagerHandlerApplication->createAgentHandleTenant($handlerId, $userId);
    }
    public function invitationLandlordVerified($ticketId, $userId)
    {
        $ticket = $this->ticketRepository->findById($ticketId);
        $isTicketTenant = $ticket->role ?? false;
        if (!$isTicketTenant) {
            throw (new Exception('Its not ticket landlord'));
        }
        $handlerId = $ticket->handlerId;
        return $this->userManagerHandlerApplication->createPmPicHandlePm($handlerId, $userId);
    }
    public function createTicketAndGetIIdByRole($role)
    {
        switch ($role) {
            case DataType::TENANT:
                $ticketId = $this->ticketAgentApplication->createTicketAndGetId(null, null, $role);
                break;
            case DataType::PM:
                break;
            default:
                break;
        }
        return $ticketId;
    }
    public function sendEmailByTicket($ticketId, $agentId = null)
    {
        $itsOkay = $this->ticketRepository->isHandleBy($agentId, $ticketId);
        if ($agentId && !$itsOkay) {
            throw (new Exception('Its not your ticket'));
        }
        $this->ticketRepository = new TicketRepository(Ticket::find($ticketId));
        $this->invitationTicketService->invite($this->ticketRepository->model);
    }
}
