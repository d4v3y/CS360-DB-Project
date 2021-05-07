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


## Pharmacy Portal:

#### Pharmacy ID:
- Purchase ID
- Drug ID
- Interactions

#### Purchase ID:
- Patient ID
- Drug ID
- Quantity
- Cost
- Insurance ID
- Referral ID

#### Interaction ID:
- Drug ID
- Patient ID
- Interaction

#### Drug ID:
- Name
- Type

## Insurance Portal:

#### Insurance ID:
- Name
- Annual Premium
- Lab ID
- Provider ID
- Medication ID

#### Lab ID:
- Name
- Cost
- Co-Pay

#### Medication ID:
- Drug ID
- Name
- Cost
- Co-pay

#### Provider ID:
- Name
- Cost
- Co-Pay

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
