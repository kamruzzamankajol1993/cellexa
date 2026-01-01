<script>
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    var currentPage = 1, searchTerm = '', sortColumn = 'id', sortDirection = 'desc';

    var routes = {
        fetch: "{{ route('ajax.company-category.data') }}",
        show: id => `{{ route('company-category.show', ':id') }}`.replace(':id', id),
        update: id => `{{ route('company-category.update', ':id') }}`.replace(':id', id),
        delete: id => `{{ route('company-category.destroy', ':id') }}`.replace(':id', id),
        getByCompany: id => `{{ route('company-category.get-by-company', ':id') }}`.replace(':id', id),
        csrf: "{{ csrf_token() }}"
    };

    $(document).ready(function() {
        // --- Summernote Initialize ---
        $('#summernoteAdd, #summernoteEdit').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });

    // --- Data Fetching (Main Table) ---
    function fetchData() {
        $.get(routes.fetch, {
            page: currentPage,
            search: searchTerm,
            sort: sortColumn,
            direction: sortDirection
        }, function (res) {
            let rows = '';
            
            // --- লজিক: ডাটা না থাকলে No Data Found দেখাবে ---
            if (res.data.length === 0) {
                rows = `<tr>
                            <td colspan="8" class="text-center text-danger py-4">
                                <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i><br>
                                No Data Found
                            </td>
                        </tr>`;
            } else {
                // ডাটা থাকলে লুপ চালাবে
                res.data.forEach((item, i) => {
                    const statusBadge = item.status == 1 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                    
                    const companyName = item.company ? item.company.name : '<span class="text-muted">N/A</span>';
                    
                    const parentName = item.parent 
                        ? `<span class="badge bg-info text-dark">${item.parent.name}</span>` 
                        : '<span class="text-muted">-</span>';
                    
                    const imgPath = item.image 
                        ? `{{ asset('') }}public/${item.image}` 
                        : 'https://placehold.co/50x50/EFEFEF/AAAAAA&text=No+Img';

                    let descPreview = item.description 
                        ? item.description.replace(/<[^>]*>/g, '').substring(0, 50) + '...' 
                        : '';

                    rows += `<tr>
                        <td>${(res.current_page - 1) * 10 + i + 1}</td>
                        <td><img src="${imgPath}" alt="${item.name}" width="50" height="50" class="img-thumbnail" style="object-fit: cover;"></td>
                        <td>${companyName}</td>
                        <td>${parentName}</td>
                        <td>${item.name}</td>
                        <td>${descPreview}</td>
                        <td>${statusBadge}</td>
                        <td class="d-flex gap-2">
                            <button class="btn btn-sm btn-info btn-edit" data-id="${item.id}"><i class="fa fa-edit"></i></button>
                            <form action="${routes.delete(item.id)}" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="${routes.csrf}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>`;
                });
            }
            
            $('#tableBody').html(rows);

            // Pagination Logic
            let paginationHtml = '';
            if (res.last_page > 1) {
                paginationHtml += `<li class="page-item ${res.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="1">First</a></li>`;
                paginationHtml += `<li class="page-item ${res.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${res.current_page - 1}">Prev</a></li>`;
                const startPage = Math.max(1, res.current_page - 2);
                const endPage = Math.min(res.last_page, res.current_page + 2);
                for (let i = startPage; i <= endPage; i++) {
                    paginationHtml += `<li class="page-item ${i === res.current_page ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
                }
                paginationHtml += `<li class="page-item ${res.current_page === res.last_page ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${res.current_page + 1}">Next</a></li>`;
                paginationHtml += `<li class="page-item ${res.current_page === res.last_page ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${res.last_page}">Last</a></li>`;
            }
            $('#pagination').html(paginationHtml);
        });
    }

    // --- Search & Sort Listeners ---
    $('#searchInput').on('keyup', function () {
        searchTerm = $(this).val();
        currentPage = 1;
        fetchData();
    });

    $(document).on('click', '.sortable', function () {
        let col = $(this).data('column');
        sortDirection = sortColumn === col ? (sortDirection === 'asc' ? 'desc' : 'asc') : 'asc';
        sortColumn = col;
        fetchData();
    });

    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        currentPage = parseInt($(this).data('page'));
        fetchData();
    });

    // --- Parent Category Helper Function ---
    function loadCategoriesForDropdown(companyId, targetSelectId, selectedParentId = null, currentId = null) {
        const target = $(targetSelectId);
        target.html('<option value="">Loading...</option>').prop('disabled', true);

        if (!companyId) {
            target.html('<option value="">Select Company First</option>');
            return;
        }

        $.get(routes.getByCompany(companyId), function(data) {
            let options = '';

            // --- লজিক: ডাটা না থাকলে মেসেজ, থাকলে Root অপশন ---
            if (data.length === 0) {
                options = '<option value="">No Data Found</option>';
            } else {
                options = '<option value="">Root Category</option>';
            }

            data.forEach(cat => {
                // এডিট মোডে নিজেকে প্যারেন্ট হিসেবে সিলেক্ট করা যাবে না
                if (currentId && cat.id == currentId) return;
                
                const isSelected = selectedParentId && cat.id == selectedParentId ? 'selected' : '';
                options += `<option value="${cat.id}" ${isSelected}>${cat.name}</option>`;
            });
            target.html(options).prop('disabled', false);
        });
    }

    // --- Add Modal Logic ---
    $('#addCompanyId').on('change', function() {
        loadCategoriesForDropdown($(this).val(), '#addParentId');
    });

    // --- Edit Modal Logic ---
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        $.get(routes.show(id), function (data) {
            $('#editId').val(data.id);
            $('#editCompanyId').val(data.company_id);
            $('#editName').val(data.name);
            
            // Summernote Data Set
            let description = data.description ? data.description : '';
            $('#summernoteEdit').summernote('code', description);
            
            $('#editStatus').val(data.status);
            
            if(data.image) {
                $('#editImagePreview').attr('src', `{{ asset('') }}public/${data.image}`).show();
            } else {
                $('#editImagePreview').hide();
            }

            // Load Parent Categories
            loadCategoriesForDropdown(data.company_id, '#editParentId', data.parent_id, data.id);
            
            editModal.show();
        });
    });

    // Edit Modal এ কোম্পানি পরিবর্তন করলে প্যারেন্ট ক্যাটাগরি লোড
    $('#editCompanyId').on('change', function() {
        loadCategoriesForDropdown($(this).val(), '#editParentId', null, $('#editId').val());
    });

    // --- Update Form Submission ---
    $('#editForm').on('submit', function (e) {
        e.preventDefault();
        const id = $('#editId').val();
        let formData = new FormData(this);
        formData.append('_method', 'PUT'); 
        formData.append('_token', routes.csrf);

        $.ajax({
            url: routes.update(id),
            method: 'POST', 
            data: formData,
            processData: false,
            contentType: false,
            success() {
                Swal.fire({ toast: true, icon: 'success', title: 'Updated successfully', showConfirmButton: false, timer: 3000 });
                editModal.hide();
                fetchData();
            },
            error(xhr) {
                let errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Something went wrong!';
                Swal.fire({ toast: true, icon: 'error', title: errorMsg, showConfirmButton: false, timer: 3000 });
            }
        });
    });

    // --- Delete Action ---
    $(document).on('click', '.btn-delete', function () {
        const deleteButton = $(this);
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteButton.closest('form').submit();
            }
        });
    });

    // --- Reset Modals ---
    $('#editModal').on('hidden.bs.modal', function () {
        $('#editForm')[0].reset();
        $('#editImagePreview').hide();
        $('#summernoteEdit').summernote('reset');
        $('#editParentId').html('<option value="">Root Category</option>');
    });
    
    $('#addModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
        $('#summernoteAdd').summernote('reset');
        $('#addParentId').html('<option value="">Select Company First</option>').prop('disabled', true);
    });

    fetchData(); 
</script>