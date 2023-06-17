@extends('_layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ __('Dashboard') }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">Starter</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">Customer List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions"><i class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Customer</button>
                                <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Import</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-bottom-dashed border-bottom">
                    <form>
                        <div class="row g-3">
                            <div class="col-xl-6">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Search for customer, email, phone, status or something...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xl-6">
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <div class="">
                                            <input type="text" class="form-control flatpickr-input" id="datepicker-range" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="Select date" readonly="readonly">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-sm-4">
                                        <div>
                                            <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control choices__input" data-plugin="choices" data-choices="" data-choices-search-false="" name="choices-single-default" id="idStatus" hidden="" tabindex="-1" data-choice="active"><option value="all" data-custom-properties="[object Object]">All</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="all" data-custom-properties="[object Object]" aria-selected="true">All</div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--idStatus-item-choice-4" class="choices__item choices__item--choice choices__placeholder choices__item--selectable is-highlighted" role="option" data-choice="" data-id="4" data-value="" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">Status</div><div id="choices--idStatus-item-choice-1" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="1" data-value="Active" data-select-text="Press to select" data-choice-selectable="">Active</div><div id="choices--idStatus-item-choice-2" class="choices__item choices__item--choice is-selected choices__item--selectable" role="option" data-choice="" data-id="2" data-value="all" data-select-text="Press to select" data-choice-selectable="">All</div><div id="choices--idStatus-item-choice-3" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="3" data-value="Block" data-select-text="Press to select" data-choice-selectable="">Block</div></div></div></div>
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-sm-4">
                                        <div>
                                            <button type="button" class="btn btn-primary w-100"> <i class="ri-equalizer-fill me-2 align-bottom"></i>Filters</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </form>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>

                                    <th class="sort" data-sort="customer_name">Customer</th>
                                    <th class="sort" data-sort="email">Email</th>
                                    <th class="sort" data-sort="phone">Phone</th>
                                    <th class="sort" data-sort="date">Joining Date</th>
                                    <th class="sort" data-sort="status">Status</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list form-check-all"><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ10</a></td>
                                    <td class="customer_name">Timothy Smith</td>
                                    <td class="email">timothysmith@velzon.com</td>
                                    <td class="phone">973-277-6950</td>
                                    <td class="date">13 Dec, 2021</td>
                                    <td class="status"><span class="badge badge-soft-success text-uppercase">Active</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ9</a></td>
                                    <td class="customer_name">Herbert Stokes</td>
                                    <td class="email">herbertstokes@velzon.com</td>
                                    <td class="phone">312-944-1448</td>
                                    <td class="date">20 Jul, 2021</td>
                                    <td class="status"><span class="badge badge-soft-danger text-uppercase">Block</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ8</a></td>
                                    <td class="customer_name">Charles Kubik</td>
                                    <td class="email">charleskubik@velzon.com</td>
                                    <td class="phone">231-480-8536</td>
                                    <td class="date">25 Sep, 2021</td>
                                    <td class="status"><span class="badge badge-soft-danger text-uppercase">Block</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ7</a></td>
                                    <td class="customer_name">Glen Matney</td>
                                    <td class="email">glenmatney@velzon.com</td>
                                    <td class="phone">515-395-1069</td>
                                    <td class="date">02 Nov, 2021</td>
                                    <td class="status"><span class="badge badge-soft-success text-uppercase">Active</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ6</a></td>
                                    <td class="customer_name">Carolyn Jones</td>
                                    <td class="email">carolynjones@velzon.com</td>
                                    <td class="phone">414-453-5725</td>
                                    <td class="date">07 Jun, 2021</td>
                                    <td class="status"><span class="badge badge-soft-success text-uppercase">Active</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ5</a></td>
                                    <td class="customer_name">Kevin Dawson</td>
                                    <td class="email">kevindawson@velzon.com</td>
                                    <td class="phone">213-741-4294</td>
                                    <td class="date">14 Mar, 2021</td>
                                    <td class="status"><span class="badge badge-soft-success text-uppercase">Active</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ4</a></td>
                                    <td class="customer_name">Michael Morris</td>
                                    <td class="email">michaelmorris@velzon.com</td>
                                    <td class="phone">805-447-8398</td>
                                    <td class="date">19 May, 2021</td>
                                    <td class="status"><span class="badge badge-soft-danger text-uppercase">Block</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr><tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ3</a></td>
                                    <td class="customer_name">Robert McMahon</td>
                                    <td class="email">robertmcmahon@velzon.com</td>
                                    <td class="phone">786-253-9927</td>
                                    <td class="date">12 Jan, 2021</td>
                                    <td class="status"><span class="badge badge-soft-success text-uppercase">Active</span></td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Remove" data-bs-original-title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr></tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ customer We did not find any customer for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2" style="display: flex;">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"><li class="active"><a class="page" href="#" data-i="1" data-page="8">1</a></li><li><a class="page" href="#" data-i="2" data-page="8">2</a></li></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field">

                                        <div class="mb-3" id="modal-id" style="display: none;">
                                            <label for="id-field1" class="form-label">ID</label>
                                            <input type="text" id="id-field1" class="form-control" placeholder="ID" readonly="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Customer Name</label>
                                            <input type="text" id="customername-field" class="form-control" placeholder="Enter name" required="">
                                            <div class="invalid-feedback">Please enter a customer name.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email-field" class="form-label">Email</label>
                                            <input type="email" id="email-field" class="form-control" placeholder="Enter email" required="">
                                            <div class="invalid-feedback">Please enter an email.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone-field" class="form-label">Phone</label>
                                            <input type="text" id="phone-field" class="form-control" placeholder="Enter phone no." required="">
                                            <div class="invalid-feedback">Please enter a phone.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="date-field" class="form-label">Joining Date</label>
                                            <input type="text" id="date-field" class="form-control flatpickr-input" data-provider="flatpickr" data-date-format="d M, Y" required="" placeholder="Select date" readonly="readonly">
                                            <div class="invalid-feedback">Please select a date.</div>
                                        </div>

                                        <div>
                                            <label for="status-field" class="form-label">Status</label>
                                            <div class="choices" data-type="select-one" tabindex="0" role="combobox" aria-autocomplete="list" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control choices__input" data-choices="" data-choices-search-false="" name="status-field" id="status-field" required="" hidden="" tabindex="-1" data-choice="active"><option value="" data-custom-properties="[object Object]">Status</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__placeholder choices__item--selectable" data-item="" data-id="1" data-value="" data-custom-properties="[object Object]" aria-selected="true">Status</div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><input type="text" class="choices__input choices__input--cloned" autocomplete="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" aria-label="Status" placeholder=""><div class="choices__list" role="listbox"><div id="choices--status-field-item-choice-3" class="choices__item choices__item--choice is-selected choices__placeholder choices__item--selectable is-highlighted" role="option" data-choice="" data-id="3" data-value="" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">Status</div><div id="choices--status-field-item-choice-1" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="1" data-value="Active" data-select-text="Press to select" data-choice-selectable="">Active</div><div id="choices--status-field-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="Block" data-select-text="Press to select" data-choice-selectable="">Block</div></div></div></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Add Customer</button>
                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                            <h4>Are you sure ?</h4>
                                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this record ?</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn w-sm btn-danger" id="delete-record">Yes, Delete It!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
@endsection
