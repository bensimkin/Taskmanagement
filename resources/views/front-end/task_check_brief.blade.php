@include('layout.header')

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('layout.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
            @include('layout.navbar')

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-style1">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard.view') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        {{ $title }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            @php
                                $permissions = session('permissions');
                            @endphp
                            @if (in_array('create_task_brief_question', $permissions))
                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                    data-bs-target="#create_status_modal">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="right" data-bs-original-title="Create Check Brief Item">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                {{-- <input type="hidden" id="data_type" value="status"> --}}
                                <table id="table" data-toggle="table" data-loading-template="loadingTemplate"
                                    data-url="{{ route('task.checklist.template.list') }}" data-icons-prefix="bx"
                                    data-icons="icons" data-show-refresh="true" data-total-field="total"
                                    data-trim-on-search="false" data-data-field="rows"
                                    data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false"
                                    data-side-pagination="server" data-show-columns="true" data-pagination="true"
                                    data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true"
                                    data-query-params="queryParams">
                                    <thead>
                                        <tr>
                                            {{-- <th data-checkbox="true"></th> --}}
                                            <th data-sortable="true" data-field="id">{{ get_label('id', 'ID') }}</th>
                                            <th data-sortable="true" data-field="template_name">
                                                {{ get_label('template_name', 'Template Name') }}</th>
                                            <th data-sortable="true" data-field="checklist">
                                                {{ get_label('checklist', 'Check List') }}</th>
                                            <th data-field="actions">{{ get_label('actions', 'Actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script>
                        var label_update = '{{ get_label('update', 'Update') }}';
                        var label_delete = '{{ get_label('delete', 'Delete') }}';
                    </script>
                    <script src="{{ asset('front-end/assets/js/pages/taskbriefquestion.js') }}"></script>
                </div>

                <!-- Create Status Modal -->
                <!-- Create Status Modal -->
                <div class="modal fade" id="create_status_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form class="modal-content form-submit-event" action="{{ route('task.checklist.store') }}"
                            method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Create Check Brief Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label" for="template_names">Template Names<span
                                                class="asterisk">*</span></label>
                                        <select class="form-select text-capitalize js-example-basic-multiple"
                                            id="template_names" name="template_name">
                                            <option value="">Please select</option>
                                            @foreach ($templates as $taskbrief_template)
                                                <option value="{{ $taskbrief_template->id }}">
                                                    {{ $taskbrief_template->template_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="all_check_lists"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Add Check List<span
                                                        class="asterisk">*</span></label>
                                            </div>
                                            <div class="col-md-6">
                                                <a class="checkBriefaddButton d-block text-end"
                                                    href="javascript:void(0);">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-placement="right">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control checkbrief mt-3"
                                            placeholder="Enter check brief" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submit_btn">Create</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Status Modal -->
                <div class="modal fade" id="edit_checklist_modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('task.checklist.update') }}" class="modal-content form-submit-event"
                            method="POST">
                            @csrf
                            <input type="hidden" name="id" id="checklist_id">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Update Check Brief Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label class="form-label" for="template_names">Template Names<span
                                                class="asterisk">*</span></label>
                                        <select class="form-select text-capitalize js-example-basic-multiple"
                                            id="update_template_names" name="template_name">
                                            <option value="">Please select</option>
                                            @foreach ($templates as $taskbrief_template)
                                                <option value="{{ $taskbrief_template->id }}">
                                                    {{ $taskbrief_template->template_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="all_check_lists" id="checklist-container"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">update Check List<span
                                                        class="asterisk">*</span></label>
                                            </div>
                                            <div class="col-md-6">
                                                <a class="checkBriefaddButton d-block text-end"
                                                    href="javascript:void(0);">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-placement="right">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control checkbrief mt-3"
                                            placeholder="Enter check brief" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="submit_btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    // Attach event listener to all buttons with the class checkBriefaddButton
                    document.querySelectorAll('.checkBriefaddButton').forEach(function(button) {
                        button.addEventListener('click', function() {
                            const modalBody = this.closest('.modal-body');
                            const inputText = modalBody.querySelector('.checkbrief').value;
                            const checkListContainer = modalBody.querySelector('.all_check_lists');

                            if (inputText.trim() !== "") {
                                // Check if the heading "Added Checklists" already exists
                                let heading = modalBody.querySelector('.addedChecklistsHeading');
                                if (!heading) {
                                    heading = document.createElement('h3');
                                    heading.classList.add('addedChecklistsHeading');
                                    heading.textContent = 'Added Checklists';
                                    checkListContainer.prepend(heading);
                                }

                                // Create a wrapper div to hold both the input and the delete icon
                                const inputWrapper = document.createElement('div');
                                inputWrapper.style.display = 'flex';
                                inputWrapper.style.alignItems = 'center';
                                inputWrapper.style.marginTop = '10px';

                                // Create the new input element
                                const newInput = document.createElement('input');
                                newInput.type = 'text';
                                newInput.value = inputText;
                                newInput.name = 'check_brief[]';
                                newInput.style.backgroundColor = 'transparent';
                                newInput.style.border = 'none';
                                newInput.style.width = '100%';
                                newInput.readOnly = true; // Make input read-only
                                newInput.style.outline = 'none'; // Remove focus outline
                                newInput.style.pointerEvents = 'none'; // Disable focus and interaction

                                // Create the delete icon (using a simple "x" or a font-awesome icon)
                                const deleteIcon = document.createElement('i');
                                deleteIcon.classList.add('fa', 'fa-trash'); // For Font Awesome trash icon
                                deleteIcon.style.cursor = 'pointer';
                                deleteIcon.style.marginLeft = '10px';
                                deleteIcon.addEventListener('click', function() {
                                    checkListContainer.removeChild(inputWrapper); // Remove the wrapper div
                                });

                                // Append the input and delete icon to the wrapper div
                                inputWrapper.appendChild(newInput);
                                inputWrapper.appendChild(deleteIcon);

                                // Append the wrapper div to the container
                                checkListContainer.appendChild(inputWrapper);
                                // Clear the input field
                                modalBody.querySelector('.checkbrief').value = '';
                            }
                        });
                    });
                </script>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel2">Warning</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" id="confirmDelete">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>

                @include('layout.labels')
            </div>
            <!-- Content wrapper -->

            <!-- Footer -->
            @include('layout.footer_bottom')
        </div>
        <!-- / Layout page -->
    </div>
    <!-- / Layout container -->
</div>
<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
<!-- / Layout wrapper -->

@include('layout.footer_links')

</body>

</html>