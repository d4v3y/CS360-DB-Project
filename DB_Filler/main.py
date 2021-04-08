import mysql.connector as mysql
import urllib
import random
import argparse
from faker import Faker
from dateutil.relativedelta import relativedelta
import datetime as date
import pandas as pd
import numpy as np

# Took drug name and administration type from excel spreadsheet from FDA
product = pd.read_excel('product.xls', index_col=None, usecols="D,G")
# Grab only the name and admonstration type
df1 = pd.DataFrame(product, columns=['PROPRIETARYNAME', 'DOSAGEFORMNAME'])

symptom_arr = ['N/A', 'Mild', 'Severe', 'Critical']

#Gathering Input
if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="random-id-gen.py")

parser.add_argument("-a", type=int, required=True,dest="amount", help="number of ID's to generate")
parser.add_argument("-v", default=False, action="store_true", dest="verbose", help="verbose output flag")
parser.add_argument("-patients", default=False, action="store_true", dest="Patients", help="Set if you need to insert into Patients table")
parser.add_argument("-drugs",default=False,action="store_true",dest="Drugs",help="Set if you need to insert into Drugs table")
parser.add_argument("-insurance",default=False,action='store_true',dest="Insurance",help="set if you need to insert into insurance information")
parser.add_argument("-interactions", default=False,action='store_true',dest="Interactions",help="set if you need interaction information")
parser.add_argument("-medication", default=False,action='store_true',dest="Medication",help="set if you need medication cost information")
parser.add_argument("-lab", default = False, action='store_true',dest="Lab", help="set if you need Lab information" )
parser.add_argument("-purchases", default=False, action='store_true',dest="Purchases", help= "set if you need purchase information")
parser.add_argument("-pharmacy", default=False, action='store_true', dest="Pharmacy", help="set if you need pharmacy information")
parser.add_argument("-provider", default=False, action='store_true',dest= "Provider", help="set if you need provider information")
parser.add_argument("-host", type=str, required=False, default=None, dest="host", help="Hostname for DB")
parser.add_argument("-port", type=int, required=False, default=None, dest="port", help="Port number for DB")
parser.add_argument("-user", type=str, required=False, default=None, dest="user", help="Username for DB")
parser.add_argument("-pass", type=str, required=False, default=None, dest="password", help="Password for DB")
parser.add_argument("-db", type=str, required=False, default=None, dest="database", help="Database to connect too")
args = parser.parse_args()

if args.host:
    # Connect to our MySQL server.
    mydb = mysql.connect(host=args.host, port=args.port, user=args.user,
                         password=args.password, database=args.database)

    # Any query results will be returned as a named dictionary
    mycursor = mydb.cursor(dictionary=True)

# SQL Statements for tables"
insert_Patients = """INSERT INTO Patients(PatientID, Name, Age, Annual_Income, SSN, City, State, Zip, InsuranceID, PharmacyID, Date_Of_Birth) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
insert_Drugs = """INSERT INTO Drugs(DrugID,Name,Type,Cost) VALUES (%s, %s, %s, %s)"""
insert_Insurance = """INSERT INTO Insurance(Name, Annual Premium, Annual Deductible, Coverage, Lifetime Coverage) VALUES (%s, %s, %s, %s, %s)"""
insert_Interactions = """INSERT INTO Interactions(Interaction ID, Symptoms) VALUES (%s, %s)"""
insert_Lab = """INSERT INTO Lab(Lab ID, Name, Cost, Copay) VALUES (%s, %s, %s, %s, %s)"""
insert_Medication = """INSERT INTO Medication(Co-pay) VALUES (%s)"""
insert_Purchases = """INSERT INTO Purchases(Purchase ID, Referral ID, Quantity, Cost) VALUES (%s, %s, %s, %s)"""
insert_Pharmacy = """INSERT INTO Pharmacy(Pharmacy ID, Name, City, State, Zipcode) VALUES (%s, %s, %s, %s, %s)"""
insert_Provider = """INSERT INTO Provider(Provider ID, Name, Cost, Co-pay) VALUES (%s, %S, %s, %s)"""
random.seed()
fake =Faker()

for i in range(0,args.amount):
    try:
        if args.Patients:

            # Let's generate all the data first
            # Must be a string to Zero Pad, 9223372036854775807 is bigint unsided MySQL max value
            ran_PatientID = str(random.randint(0, 9223372036854775807))
            ran_InsuranceID = str(random.randint(0, 9223372036854775807))
            ran_PharmacyID = str(random.randint(0, 9223372036854775807))
            # Print and Zero Pad if needed.
            ran_PatientID = ran_PatientID.zfill(20)
            ran_InsuranceID = ran_InsuranceID.zfill(20)
            ran_PharmacyID = ran_PharmacyID.zfill(20)
            # Birthdays. Lets make them in MySQL format
            ran_Date_Of_Birth = fake.date(pattern='%Y-%m-%d', end_datetime=None)
            # Annual Income is randomly generated
            ran_Annual_Income = str(random.randint(0,9983252))
            # Calculate the Age
            today = date.datetime.today()
            age = relativedelta(
                today, date.datetime.strptime(ran_Date_Of_Birth, "%Y-%m-%d"))
            ran_Age = age.years
            #Use fake package to generate other data
            ran_State = fake.state()
            ran_ZIP = fake.zip()
            ran_SSN = fake.ssn()
            ran_City = fake.city()
            ran_Name = fake.name()

            if args.verbose:
                #print confirmation if verbose
                print(ran_PatientID)
                print(ran_Name)
                print(ran_Age)
                print(ran_Annual_Income)
                print(ran_SSN)
                print(ran_City)
                print(ran_State)
                print(ran_ZIP)
                print(ran_InsuranceID)
                print(ran_PharmacyID)
                print(ran_Date_Of_Birth)

            # Check to make sure the connection is present
            if args.host and args.port and args.user and args.password and args.database:
                mycursor.execute(insert_Patients,
                                 (int(ran_PatientID),
                                  ran_Name,
                                  ran_Age,
                                  ran_Annual_Income,
                                  ran_SSN,
                                  ran_City,
                                  ran_State,
                                  ran_ZIP,
                                  ran_InsuranceID,
                                  ran_PharmacyID,
                                  ran_Date_Of_Birth))
                mydb.commit()

            else:
                print(
                    "Error Inserting into Patients: One of hostname, username, password, database name, or patients flag is missing!")
                break

        elif args.drugs:

            #pick a random row
            info = df1.sample()
            #assign the name and type
            name = info.PROPRIETARYNAME.to_numpy()
            type = info.DOSAGEFORMNAME.to_numpy()

            #Generating Data
            #Make a Unique DrugID
            ran_DrugID = str(random.randint(0, 9223372036854775807))
            ran_DrugID = ran_DrugID.zfill(20)
            #Get name and type from list
            ran_DName = ''.join(name)
            ran_Type = ''.join(type)
            ran_dcost = str(random.randint(5, 9983))

            if args.verbose:
                print(ran_DrugID)
                print(ran_DName)
                print(ran_Type)
                print(ran_dcost)

            if args.host and args.port and args.user and args.password and args.database:
                 mycursor.execute(insert_Drugs,
                            (int(ran_DrugID),
                            ran_DName,
                            ran_Type,
                            ran_dcost))

                 mydb.commit()

            else:
                print("Error Inserting into Drugs: One of hostname, username, password, database name, or patients flag is missing!")


        elif args.insurance:
            #Importing Data
            sqlquery1 = """INSERT INTO Insurance(Patient ID, Insurance ID) SELECT PatientID,InsuranceID FROM Patients """
            mycursor.execute(sqlquery1)

            results = mycursor.fetchall()
            if results:
                # Generating Data
                ran_cname = fake.company()
                ran_annual_premium = str(random.randint(100, 998325))
                ran_annual_deductible = str(random.randint(100, 9983))
                ran_coverage = str(random.randint(25, 95)) + '%'
                ran_lifetime_coverage = str(random.randint(1000, 998399295))

                if args.verbose:
                    print(ran_cname)
                    print(ran_annual_premium)
                    print(ran_annual_deductible)
                    print(ran_coverage)
                    print(ran_lifetime_coverage)

                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_Insurance,
                         (ran_cname,
                          ran_annual_premium,
                          ran_annual_deductible,
                          ran_coverage,
                          ran_lifetime_coverage))

                mydb.commit()

            else:
                print("Error Inserting into Insurance: One of hostname, username, password, database name, or patients flag is missing!")

        elif args.interactions:
            # Importing Data
            sqlquery1 = """INSERT INTO Interactions(Patient ID) SELECT PatientID FROM Patients """
            mycursor.execute(sqlquery1)

            sqlquery2 = """INSERT INTO Interactions(DrugID) SELECT DrugID FROM Drugs """
            mycursor.execute(sqlquery2)



            results = mycursor.fetchall()
            if results:
                # Generating Data
                ran_InteractionID = str(random.randint(0, 9223372036854775807))
                ran_InteractionID = ran_InteractionID.zfill(20)
                symptom = np.random.choice(symptom_arr,1)
                ran_symptom =''.join(symptom)

                if args.verbose:
                    print(ran_InteractionID)
                    print(ran_symptom)


                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_Drugs,
                                     (int(ran_InteractionID),
                                      ran_symptom))

                mydb.commit()

            else:
                print("Error Inserting into Interaction: One of hostname, username, password, database name, drugs, or patients flag is missing!")

        elif args.lab:
            # Importing Data
            sqlquery1 = """INSERT INTO Lab(Insurance ID) SELECT InsuranceID FROM Patients """
            mycursor.execute(sqlquery1)

            results = mycursor.fetchall()
            if results:
                # Generating Data
                ran_LabID = str(random.randint(0, 9223372036854775807))
                ran_LabID = ran_LabID.zfill(20)
                ran_lname = fake.company()
                ran_lcost = str(random.randint(50, 9983))
                ran_lcopay = str(random.randint(0, 50))

                if args.verbose:
                    print(ran_LabID)
                    print(ran_lname)
                    print(ran_lcost)
                    print(ran_lcopay)

                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_Lab,
                                (int(ran_LabID),
                                ran_lname,
                                ran_lcost,
                                ran_lcopay))
                mydb.commit()

            else:
                print("Error Inserting into Labs: One of hostname, username, password, database name, or patients flag is missing!")

        elif args.medication:
            sqlquery1 = """INSERT INTO Medication(Drug ID, Name, Cost) SELECT DrugID, Dname, dcost FROM Drugs """
            mycursor.execute(sqlquery1)

            sqlquery2 = """INSERT INTO Medication(Insurance ID) SELECT InsuranceID FROM Patients """
            mycursor.execute(sqlquery2)

            results = mycursor.fetchall()

            if results:
                ran_dcopay = str(random.randint(5, 50))

                if args.verbose:
                    print(ran_dcopay)

                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_Medication, (ran_dcopay))
                mydb.commit()

            else:
                print("Error Inserting into Medication: One of hostname, username, password, database name, drugs, or patients flag is missing!")


        elif args.purchases:
            sqlquery1 = """INSERT INTO Purchases(Patient ID, Insurance ID) SELECT PatientID,InsuranceID FROM Patients"""
            mycursor.execute(sqlquery1)
            sqlquery2 = """INSERT INTO Purchases(Interaction ID, Drug ID) SELECT Interaction ID, Drug ID FROM Interactions WHERE Patient ID = Patient ID"""
            mycursor.execute(sqlquery2)
            sqlquery3 = """INSERT INTO Purchases(Pharmacy ID) SELECT Pharmacy ID FROM Pharmacy"""
            results=mycursor.fetchall()
            if results:
                ran_PurchaseID = str(random.randint(0, 9223372036854775807))
                ran_PurchaseID = ran_PurchaseID.zfill(20)
                ran_ReferralID = str(random.randint(0, 9223372036854775807))
                cpay= """SELECT Co-Pay FROM Medications WHERE Insurance ID = Insurance ID"""
                ran_Quantity = str(random.randint(0,100))
                ran_Cost = mycursor.execute(cpay) * ran_Quantity

                if args.verbose:
                    print(ran_PurchaseID)
                    print(ran_ReferralID)
                    print(ran_Quantity)
                    print(ran_Cost)
                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_Purchases, (ran_PurchaseID,
                                                        ran_ReferralID,
                                                        ran_Quantity,
                                                        ran_Cost))
                mydb.commit()

            else:
                print("Error Inserting into Purchases: One of hostname, username, password, database name, Interactions, Medications, or patients flag is missing!")

        elif args.pharmacy:
                ran_PharmacyID = str(random.randint(0, 9223372036854775807))
                ran_PharmacyID = ran_PharmacyID.zfill(20)
                ran_Pname = fake.company()
                ran_Pcity = fake.city()
                ran_Pstate = fake.state()
                ran_Pzip = fake.zip()

                if args.verbose:
                    print(ran_PharmacyID)
                    print(ran_Pname)
                    print(ran_Pcity)
                    print(ran_Pstate)
                    print(ran_Pzip)
                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_Pharmacy, (ran_PharmacyID,
                                                        ran_Pname,
                                                        ran_Pcity,
                                                        ran_Pstate,
                                                        ran_Pzip))
                    mydb.commit()
                else:
                    print("Error Inserting into Pharmacy: One of hostname, username, password, or database name")

        elif args.provider:
            sqlquery1 = """INSERT INTO (Insurance ID) SELECT InsuranceID FROM Patients"""
            mycursor.execute(sqlquery1)

            results = mycursor.fetchall
            if results:
                ran_ProviderID = str(random.randint(0, 9223372036854775807))
                ran_ProviderID = ran_ProviderID.zfill(20)
                ran_Hname = fake.company()
                ran_Hcost = str(random.randint(100, 99837))
                ran_Hcopay = str(random.randint(10, 998))

                if args.verbose:
                    print(ran_ProviderID)
                    print(ran_Hname)
                    print(ran_Hcost)
                    print(ran_Hcopay)
                if args.host and args.port and args.user and args.password and args.database:
                    mycursor.execute(insert_Provider, (ran_ProviderID,
                                                        ran_Hname,
                                                        ran_Hcost,
                                                        ran_Hcopay))
                mydb.commit()
            else:
                print("Error Inserting into Provider: One of hostname, username, password, database name, or patients")

    except KeyboardInterrupt:
        mydb.commit()
        mydb.close()

