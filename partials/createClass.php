<?php

// Check if the user is logged in and if their role is 'Teacher'
if (isset($_SESSION['role']) && $_SESSION['role'] === 'Teacher') :
?>
    <!-- Modal for Creating Class -->
    <div class="modal fade" id="createClassModal" tabindex="-1" role="dialog" aria-labelledby="createClassModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createClassModalLabel">Create Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createClassForm">
                        <div class="form-group">
                            <label for="className">Class Name:</label>
                            <input type="text" class="form-control" id="className" name="className" required>
                        </div>
                        <div class="form-group">
                            <label for="section">Section:</label>
                            <input type="text" class="form-control" id="section" name="section" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <button type="submit" class="btn btn-success">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>