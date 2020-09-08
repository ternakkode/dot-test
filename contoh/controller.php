<?php
namespace App\Http\Controllers\Api\V1\Supply;
use App\Domain\Ticket\Application\GetTicketInvitationApplication;
use App\Domain\Ticket\Application\InvitationApplication;
use App\Domain\Ticket\Application\TicketInvitationApplication;
use App\Domain\Ticket\Services\TicketService;
use App\Domain\UserManagement\Models\UserModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Supply\TicketSubmitRequest;
use App\Http\Requests\API\V1\Ticket\VerifyRequest;
use App\Http\Resources\API\V1\Ticket\Agent\TicketInvitationDirectory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TicketController extends Controller
{
    /**
     *
     * service variable
     * @var TicketService $service
     */
    public $invitationApplication;
    public $getTicketInvitationApplication;
    public $ticketInvitationApplication;
    /**
     * construct
     * @return void
     */
    public function __construct(
        TicketInvitationApplication $ticketInvitationApplication,
        InvitationApplication $invitationApplication,
        GetTicketInvitationApplication $getTicketInvitationApplication
    ) {
        $this->ticketInvitationApplication = $ticketInvitationApplication;
        $this->invitationApplication = $invitationApplication;
        $this->getTicketInvitationApplication = $getTicketInvitationApplication;
    }
    /**
     * create ticket submit request for role
     *
     * @param TicketSubmitRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(TicketSubmitRequest $request)
    {
        $user = Auth::user();
        $this->ticketInvitationApplication->createTicketInvitation(
            $user->fullname,
            $user->email,
            $user->phone,
            $user->type,
            $request->role
        );
        return rest_api('Success request new ticket');
    }
    /**
     * Display the specified resource.
     *
     * @param int $ticket_code
     * @return JsonResponse
     */
    public function show($ticket_code)
    {
        $ticket = $this->getTicketInvitationApplication->byCode($ticket_code);
        if ($ticket) {
            return rest_api(new TicketInvitationDirectory($ticket));
        }
        return rest_api(null);
    }
    /**
     * verify ticket
     *
     * @param VerifyRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function verify(VerifyRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->ticketInvitationApplication->verify(
                $request->ticket_code,
                $request->fullname,
                $request->phone,
                $request->password,
                $request->type
            );
            DB::commit();
            return rest_api('Success verify code');
        } catch (Exception $err) {
            DB::rollBack();
            report($err);
            return rest_error(null, 'An error occured');
        }
    }
}