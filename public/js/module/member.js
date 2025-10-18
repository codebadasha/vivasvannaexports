// Team member Switch Status Change
$(document).on('change', '.teamMemberStatus', function() {
    let option = this.checked ? 1 : 0;
    let id = $(this).data('id');

    $.ajax({
        url: "/admin/team/change-team-member-status",
        method: 'POST',
        data: { option: option, id: id },
        success: function(data) {
            if (data.status) {
                if (option === 1) {
                    toastr.success('Team member successfully activated');
                } else {
                    toastr.success('Team member successfully deactivated');
                }
            } else {
                toastr.error(data.message || 'Something went wrong');
                // revert toggle back if update failed
                $(`.teamMemberStatus[data-id="${id}"]`).prop('checked', option === 1 ? false : true);
            }
        },
        error: function() {
            toastr.error('Server error occurred');
            // revert toggle back on failure
            $(`.teamMemberStatus[data-id="${id}"]`).prop('checked', option === 1 ? false : true);
        }
    });
});

// Remove error message for select role
$(document).on('change', '#role_id', function(){
    $('#addTeamMember').valid();
});

$(document).on('change', '.setDefaultTeamMember', function() {
    let id = $(this).data('id');

    $.ajax({
        url: "/admin/team/set-default-team-member",
        method: 'POST',
        data: { id: id },
        success: function(data) {
            if (data.status) {
                toastr.success(data.message);
            } else {
                toastr.error(data.message || 'Something went wrong while setting default team member');
            }
        },
        error: function() {
            toastr.error('Server error occurred');
        }
    });
});
