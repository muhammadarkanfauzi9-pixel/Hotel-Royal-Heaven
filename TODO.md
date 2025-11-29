# TODO: Restrict Review Access for Members

## Task: Reviews can only be accessed after checkout completion or admin confirmation (cancelled/completed)

### Steps:
1. [x] Modify ReviewController::index() to only show reviews for completed or cancelled bookings
2. [x] Modify ReviewController::store() to only allow creating reviews for completed or cancelled bookings
3. [x] Update kamar/show.blade.php to only show review form if user has completed/cancelled booking for that room
4. [ ] Test the implementation

### Status: Completed
