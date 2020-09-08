<?php
​
​
use App\Domain\PropertyManagement\Repositories\AdvancedQueryPreset\AdvanceFilterByPropertyType;
use App\Domain\PropertyManagement\Repositories\PropertyTypeRepository;
use App\Domain\Ticket\Entities\Ticket;
use App\Domain\Ticket\Model\TicketCreationModel;
use App\Infrastructure\PaginationModel;
use App\Infrastructure\RepositoryOptionModel;
use App\Supports\Models\DataType;
use App\Supports\Models\ModelGenerator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
​
class TicketRepository
{
    public $model;
    /**
     * @var PropertyTypeRepository $propertyTypeRepository
     */
    protected $propertyTypeRepository;
    /**
     * @var AdvanceFilterByPropertyType $advanceFilterByPropertyType
     */
    private $advanceFilterByPropertyType;
​
    public function __construct(
        Ticket $model
    ) {
        $this->model = $model;
        $this->propertyTypeRepository = new PropertyTypeRepository();
        $this->advanceFilterByPropertyType = new AdvanceFilterByPropertyType();
    }
​
    public function create(TicketCreationModel $ticketCreationModel)
    {
        $this->model->handled_by = $ticketCreationModel->handled_by;
        $this->model->user_id = $ticketCreationModel->user_id;
        $this->model->role = $ticketCreationModel->role;
        $this->model->fullname = $ticketCreationModel->user_fullname;
        $this->model->email = $ticketCreationModel->user_email;
        $this->model->email_content = $ticketCreationModel->email_content;
        $this->model->phone = $ticketCreationModel->user_phone;
        $this->model->type = $ticketCreationModel->user_type;
        $this->model->notes = $ticketCreationModel->notes;
        $this->model->category = $ticketCreationModel->category;
        $this->model->property_id = $ticketCreationModel->property_id;
        $this->model->status = $ticketCreationModel->status ?? Ticket::PROCESS;
​
        return $this->model->save();
    }
​
    public function update(TicketCreationModel $ticketCreationModel)
    {
        $this->model->handled_by = $ticketCreationModel->handled_by ?? $this->model->handled_by;
        $this->model->user_id = $ticketCreationModel->user_id ?? $this->model->user_id;
        $this->model->role = $ticketCreationModel->role ?? $this->model->role;
        $this->model->fullname = $ticketCreationModel->user_fullname ?? $this->model->user_fullname;
        $this->model->email = $ticketCreationModel->user_email ?? $this->model->user_email;
        $this->model->email_content = $ticketCreationModel->email_content ?? $this->model->email_content;
        $this->model->phone = $ticketCreationModel->user_phone ?? $this->model->user_phone;
        $this->model->type = $ticketCreationModel->user_type ?? $this->model->user_type;
        $this->model->notes = $ticketCreationModel->notes ?? $this->model->notes;
        $this->model->category = $ticketCreationModel->category ?? $this->model->category;
        $this->model->status = $ticketCreationModel->status ?? $this->model->status;
        $this->model->property_id = $ticketCreationModel->property_id ?? $this->model->property_id;
​
        return $this->model->save();
    }
​
    public function changeStatusTicket($status)
    {
        $this->model->status = $status;
        return $this->model->save();
    }
​
    public function handlingList($idUser, $category)
    {
        $this->model = $this->model->with('user')->where('handled_by', $idUser)->where('category', $category)->where('status', Ticket::OPEN);
        return $this;
    }
​
    public function searchUser($columns, $search)
    {
        $this->model = $this->model->whereHas('user', function ($user) use ($search, $columns) {
            foreach ($columns as $column)
                $user = $user->where($column, 'like', '%' . $search . '%');
        });
​
        return $this;
    }
​
    public function updateAgentAndSetClose($agentId)
    {
        $this->model->handled_by = $agentId;
        $this->model->status = Ticket::CLOSED;
​
        return $this->model->save();
    }
​
    public function ticketRequestedToAgent($agentId)
    {
        $requsted = [Ticket::CATEGORY_AGENT_HANDLING_TENANT, Ticket::CATEGORY_AGENT_HANDLING_TENANT_SPECIFIC_PROPERTY];
​
        $this->model = $this->model->newQuery()
            ->where('handled_by', $agentId)
            ->where('status', Ticket::PROCESS)
            ->where('role', DataType::TENANT)
            ->whereIn('category', $requsted)
            ->orderBy('created_at', 'desc');
​
        return $this;
    }
​
    public function ticketOpenToAgent($agentId)
    {
        $this->model = $this->model->newQuery()
            ->where('handled_by', $agentId)
            ->where('status', Ticket::OPEN)
            ->where('role', DataType::TENANT);
​
        return $this;
    }
​
    public function ticketCloseToAgent($agentId)
    {
        $this->model = $this->model
            ->where('handled_by', $agentId)
            ->where('status', Ticket::CLOSED)
            ->where('role', DataType::TENANT);
​
        return $this;
    }
​
    public function ticketOpenToPmPic($agentId)
    {
        $this->model = $this->model
            ->where('handled_by', $agentId)
            ->where('status', Ticket::OPEN)
            ->where('role', DataType::PM);
​
        return $this;
    }
​
    public function ticketCloseToPmPic($agentId)
    {
        $this->model = $this->model
            ->where('handled_by', $agentId)
            ->where('status', Ticket::CLOSED)
            ->where('role', DataType::PM);
​
        return $this;
    }
​
    public function updateAgentAndSetProcess($agentId)
    {
        $this->model->handled_by = $agentId;
        $this->model->status = Ticket::PROCESS;
​
        return $this->model->save();
    }
​
    public function setClose()
    {
        $this->model->status = Ticket::CLOSED;
        return $this->model->save();
    }
​
    public function byCategory($category)
    {
        $this->model = $this->model->where('category', $category);
        return $this;
    }
​
    public function byCategories(array $categories)
    {
        $this->model = $this->model->whereIn('category', $categories);
        return $this;
    }
​
    public function hasProperty()
    {
        $this->model = $this->model->whereNotNull('property_id');
        return $this;
    }
​
    public function setOpen()
    {
        $this->model->status = Ticket::OPEN;
​
        return $this->model->save();
    }
​
    public function isAllowToTransfer($userId)
    {
        return $this->model->where('category', Ticket::CATEGORY_AGENT_HANDLING_TENANT)->where('status', Ticket::PROCESS)->where('user_id', $userId)->count() == 0;
    }
​
    public function isHandleBy($userId, $ticketId)
    {
        return $this->model->where('id', $ticketId)->where('handled_by', $userId)->count() > 0;
    }
​
    public function isAllowToReject($agentId)
    {
        return $this->model->where('handled_by', $agentId)->where('status', Ticket::REJECT)->count() < 2;
    }
​
    public function isAllowToAccept($agentId)
    {
        return true;
    }
​
    public function rejectTicket()
    {
        $this->model->status = Ticket::REJECT;
        return $this->model->save();
    }
​
    public function findById($id)
    {
        return $this->model->find($id);
    }
​
    public function findByCode($code)
    {
        return $this->model->whereHas('invitation', function ($invitation) use ($code) {
            $invitation->where('code', $code);
        })->first();
    }
​
    public function handleBy($agentId)
    {
        $this->model = $this->model->where('handled_by', $agentId);
        return $this;
    }
​
    public function byUser($userId)
    {
        $this->model = $this->model->where('user_id', $userId);
        return $this;
    }
​
    public function byRole($role)
    {
        $this->model = $this->model->where('role', $role);
        return $this;
    }
​
    public function byStatus($role)
    {
        $this->model = $this->model->where('status', $role);
        return $this;
    }
​
    public function byProperty($propertyId)
    {
        $this->model = $this->model->where('property_id', $propertyId);
        return $this;
    }
​
    public function isExists()
    {
        $this->model = $this->model->count() > 0;
        return $this;
    }
​
    public function first()
    {
        return $this->model->first();
    }
​
    public function isTicketOpen($ticketId)
    {
        return $this->model->where('status', Ticket::OPEN)->where('id', $ticketId)->count() > 0;
    }
​
    public function getIndex(RepositoryOptionModel $options = null)
    {
        $this->model = $this->implementFilterOptions($options);
        $this->model = $this->implementSortOptions($options);
​
        if (isset($options->paginate) && ($options->paginate != null)) {
            return $this->model->paginate($options->paginate->per_page);
        } elseif (isset($options->limit) && ($options->limit != null)) {
            return $this->model->take($options->limit)->get();
        } else {
            return $this->model->get();
        }
    }
​
    public function get(PaginationModel $paginationModel = null)
    {
        if (!$paginationModel)
            return $this->model->get();
        else
            return $this->model->paginate($paginationModel->per_page);
    }
​
    public function save(TicketCreationModel $ticketModel)
    {
        $this->model->fill($ticketModel->toArray())->save();
        return $this->model;
    }
​
    public function orderByLatest()
    {
        $this->model = $this->model->orderBy('created_at', 'desc');
        return $this;
    }
​
    public function orderByOldest()
    {
        $this->model = $this->model->orderBy('created_at', 'asc');
        return $this;
    }
​
    public function setOffsetAndLimit($offset, $limit)
    {
        $this->model = $this->model->offset($offset)->limit($limit);
        return $this;
    }
​
    public function getTicketPropertyTransactionByTenant($tenant_id, RepositoryOptionModel $options)
    {
        $this->model = $this->model->where('user_id', $tenant_id);
        $this->byCategories([Ticket::CATEGORY_AGENT_HANDLING_TENANT_SPECIFIC_PROPERTY]);
        if($options->paginate){
            return $this->get($options->paginate);
        }else{
            return $this->get();
        }
​
    }
​
    public function getTicketHandlingTenant($tenant_id, $handler_id)
    {
        $this->model = $this->model->where('user_id', $tenant_id)->where('handler_id', $handler_id)->where('status', Ticket::CLOSED);
        $this->byCategories([Ticket::CATEGORY_AGENT_HANDLING_TENANT]);
        return $this->model->first();
    }
​
    /**
     * @param null $options
     * @return Ticket
     */
    private function implementSortOptions($options = null)
    {
        if ($options == null) return $this->model;
​
        if (isset($options->sort)) {
            switch ($options->sort->field) {
                case 'property.title':
                    $this->model
                        ->select('property_bid.*')
                        ->join('properties', 'property_bid.property_id', '=', 'properties.id')
                        ->orderBy('properties.title->'.app()->getLocale(), $options->sort->order ?? 'desc')
                        ->groupBy('property_bid.id');
                    break;
            }
        }
    }
}