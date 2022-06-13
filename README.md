# MyHealthProject #2 Dawson (Team Lead), Davey, & Matt
## Pharmacy and Insurance Portals 

### How to use:
  Upon, opening the website (index.php), you will be prompt to login into your account or signup as a new member. Logging in only requires your specified username and password. Signing up requires you to input your information, also to choose your username and password. Once logged on, as a Pharmacist you can view your organization’s transaction history and input referral IDs from patients to ultimately record the transaction. As a doctor you can view a patient’s information and personal referral history. You can also diagnose illnesses and record referrals to the referral table for the pharmacist to view when the patient arrives to pick up their prescription. Logging out is possible by pressing the logout button in the bottom left.

### Stages:
- Phase I project report on data modeling due on February 18
- Phase II project report on normalization and interim demo due on April 13/15
- Phase III comprehensive project report due during your demo on May 3 - 7


### Primary Application: Pharmacy Portal

### Secondary Portal: Insurance Portal


## Tables Implemented:

<table>
<tr><th>Interactions</th><th>Patients</th></tr>
<tr><td>

| Interactions |
|--------------|
| PatientID    |
| DrugID       |
| Symptom      |

</td><td>

| Patients      |
|---------------|
| **PatientID** |
| InsuranceID   |
| Access        |
| First Name    |
| Last Name     |
| Age           |
| Annual Income |
| SSN           |
| Street        |
| City          |
| State         |
| Zip           |

</td></tr> </table>

<table>
<tr><th>Table 1 Heading 1 </th><th>Table 1 Heading 2</th></tr>
<tr><td>

|Table 1| Middle | Table 2|
|--|--|--|
|a| not b|and c |

</td><td>

|b|1|2|3| 
|--|--|--|--|
|a|s|d|f|

</td></tr> </table>

## Scheme Used:

### *SSDO(Patient(primary),Insurance, Pharmacy)*

## Technology:
- IDEs - Visual Studio, MySQL Workbench
- Host Website - Github Pages
- DB Server - phpMyAdmin
- Frontend - HTML/CSS/JS
- Backend - PHP/MySQL
- Version Control - GitHub
- Tools: WinSCP
