<div class="modal-header">
    <h4 class="modal-title">Contact Persons - {{ $company->company_name }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <!--  -->

    <table class="table table-bordered" id="contactPersonsTable">
        <thead class="table-light">
            <tr>
                <th>Sr. No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Primary</th>
                <th class="text-center" width="120">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($contacts->isNotEmpty())
                @foreach($contacts as $key => $contact)
                <tr data-id="{{ $contact->id }}" data-zoho-id="{{ $contact->contact_person_id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="name">{{ $contact->name }}</td>
                    <td class="email">{{ $contact->email ?? '-' }}</td>
                    <td class="mobile">{{ $contact->mobile }}</td>
                    <td class="phone">{{ $contact->phone ?? '-' }}</td>
                    <td class="designation">{{ $contact->designation ?? '-' }}</td>
                    <td class="text-center primary-col">
                        @if($contact->is_primary)
                            <span class="badge bg-success">Primary</span>
                        @else
                            <button class="btn btn-sm btn-outline-success set-primary-contact-btn" data-id="{{ $contact->id }}">
                                Set Primary
                            </button>
                        @endif
                    </td>
                    <td class="text-center action-col">
                        <button class="btn btn-sm btn-outline-primary contact-edit-btn" data-id="{{ $contact->id }}">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger contact-delete-btn" data-id="{{ $contact->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">No records found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>