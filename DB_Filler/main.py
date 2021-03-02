import mysql.connector as mysql
import random
import argparse
from faker import Faker
from dateutil.relativedelta import relativedelta
import datetime as date
import panda as pd
import numpy as np

# Took drug name and administration type from excel spreadsheet from FDA
product = pd.read_excel('product.xls', index_col=None, usecols="D,G")
# Grab only the name and admonstration type
df1 = pd.DataFrame(product, columns=['PROPRIETARYNAME', 'DOSAGEFORMNAME'])

#Gathering Input
if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="random-id-gen.py")

parser.add_argument("-a", type=int, required=True,dest="amount", help="number of ID's to generate")
parser.add_argument("-v", default=False, action="store_true", dest="verbose", help="verbose output flag")
parser.add_argument("-patients", default=False, action="store_true", dest="Patients", help="Set if you need to insert into Patients table")
parser.add_argument("-drugs",default=False,action="store_true",dest="Drugs",help="Set if you need to insert into Drugs table")
parser.add_argument("-insurance",default=False,action='store_true',dest="Insurance",help="set if you need to insert into insurance information")
parser.add_argument("-interactions", default=False,action='store_true',dest="Interactions",help="set if you need interaction information")
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
insert_Drugs = """INSERT INTO Drugs(DrugID,Name,Type) VALUES (%s, %s, %s)"""
insert_Insurance = """INSERT INTO Insurance(Name, Annual Premium, Annual Deductible, Coverage, Lifetime Coverage) VALUES (%s, %s, %s, %s, %s)"""

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

            if args.verbose:
                print(ran_DrugID)
                print(ran_DName)
                print(ran_Type)

            if args.host and args.port and args.user and args.password and args.database:
                 mycursor.execute(insert_Drugs,
                            (int(ran_DrugID),
                            ran_DName,
                            ran_Type))

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
                    mycursor.execute(insert_Drugs,
                         (ran_cname,
                          ran_annual_premium,
                          ran_annual_deductible,
                          ran_coverage,
                          ran_lifetime_coverage))

                mydb.commit()

            else:
                print("Error Inserting into Insurance: One of hostname, username, password, database name, or patients flag is missing!")

        elif