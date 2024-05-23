servername = "localhost";
username = "Fidelite";
password = "222003083";
dbname = "charity_donation_management_system";

 Charity Donation Management System Documentation

 Project Structure

The Charity Donation Management System is designed to facilitate the management of donations, events, campaigns, and volunteer activities for charitable organizations. The system is structured around several key entities, each represented by a database table. Here is an overview of the project structure and the purpose of each table.
 Tables and Their Descriptions

1. Campaigns
    - Description: This table stores information about fundraising campaigns organized by the charity.
    - Key Columns:
        - campaign_id: Unique identifier for each campaign.
        - name: Name of the campaign.
        - description: Detailed description of the campaign.
        - start_date: Date when the campaign starts.
        - end_date: Date when the campaign ends.
        - target_amount: The fundraising target amount.

2. Charities
    - Description: This table contains details about the charities using the system.
    - Key Columns:
        - charity_id: Unique identifier for each charity.
        - name: Name of the charity.
        - address: Address of the charity.
        - contact_info: Contact information for the charity.

3. Donations
    - Description: This table records all donations made to the charity.
    - Key Columns:
        - donation_id: Unique identifier for each donation.
        - amount: Amount donated.
        - date: Date of donation.
        - campaign_id: ID of the campaign associated with the donation.
        - donor_id: ID of the donor making the donation.

4. DonorDetails
    - Description: This table holds information about the donors.
    - Key Columns:
        - donor_id: Unique identifier for each donor.
        - name: Name of the donor.
        - email: Email address of the donor.
        - phone: Phone number of the donor.
        - address: Address of the donor.

5. Events
    - Description: This table keeps track of events organized by the charity.
    - Key Columns:
        - event_id: Unique identifier for each event.
        - name: Name of the event.
        - date: Date of the event.
        - location: Location where the event is held.
        - description: Detailed description of the event.

6. EventVolunteers
    - Description: This table lists volunteers participating in specific events.
    - Key Columns:
        - event_volunteer_id: Unique identifier for each record.
        - event_id: ID of the associated event.
        - volunteer_id: ID of the volunteer participating in the event.

7. Fundraisers
    - Description: This table documents fundraisers working for the charity.
    - Key Columns:
        - fundraiser_id: Unique identifier for each fundraiser.
        - name: Name of the fundraiser.
        - email: Email address of the fundraiser.
        - phone: Phone number of the fundraiser.

8. Reports
    - **Description**: This table is used to generate reports related to donations, events, and campaigns.
    - Key Columns:
        - report_id: Unique identifier for each report.
        - name: Name of the report.
        - generated_date: Date when the report was generated.
        - report_data: Data contained in the report (could be in various formats like JSON, CSV).

9. Users
    - Description: This table stores information about users who have access to the system.
    - Key Columns:
        - `user_id`: Unique identifier for each user.
        - `username`: Username of the user.
        - `password_hash`: Hashed password for security.
        - `role`: Role of the user (e.g., admin, volunteer, fundraiser).

10. Volunteers
    - Description: This table contains details about volunteers who help the charity.
    - Key Columns:
        - volunteer_id: Unique identifier for each volunteer.
        - name: Name of the volunteer.
        - email: Email address of the volunteer.
        - phone: Phone number of the volunteer.

 Functionality and Usage

The Charity Donation Management System enables efficient management of charitable activities through the following functionalities:

Campaign Management
- Create, update, and manage fundraising campaigns.
- Set fundraising targets and monitor progress.

Donation Tracking
- Record donations with details like donor information, amount, and associated campaigns.
- Generate reports to analyze donation patterns and campaign effectiveness.

 Donor Management
- Maintain a database of donor details.
- Communicate with donors through email and other contact information stored in the system.

 Event Management
- Organize and schedule charity events.
- Track volunteer participation in events.

Volunteer Coordination
- Maintain a roster of volunteers.
- Assign volunteers to specific events and manage their participation.

Fundraiser Operations
- Keep track of fundraisers working for the charity.
- Assign fundraisers to specific campaigns and monitor their performance.

Reporting and Analysis
- Generate detailed reports on various aspects of the charity's operations.
- Use reports to make data-driven decisions and improve the effectiveness of campaigns and events.

 User Management
- Manage user access and roles within the system.
- Ensure security through hashed passwords and role-based access control.

By leveraging these functionalities, charitable organizations can streamline their operations, improve donor engagement, and maximize their impact.

