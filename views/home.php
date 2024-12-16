<div class="dashboard-header">
    <h2>Dashboard</h2>
    <a href="#" class="btn-primary" data-page="new-contact">Add Contact</a>
</div>
<div class="filter-container">
    <button class="filter-btn active" data-filter="all">All Contacts</button>
    <button class="filter-btn" data-filter="sales">Sales Leads</button>
    <button class="filter-btn" data-filter="support">Support</button>
    <button class="filter-btn" data-filter="assigned">Assigned to me</button>
</div>
<div class="contacts-table-container">
    <table class="contacts-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="contacts-list">
            <!-- Contacts will be loaded here via AJAX -->
        </tbody>
    </table>
</div>