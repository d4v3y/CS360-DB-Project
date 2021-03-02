import mysql.connector as mysql
import random
import argparse
from faker import Faker
from dateutil.relativedelta import relativedelta
import datetime as date
#Gathering Input
if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="random-id-gen.py")

parser.add_argument("-a", type=int, required=True,dest="amount", help="number of ID's to generate")
parser.add_argument("-v", default=False, action="store_true", dest="verbose", help="verbose output flag")
parser.add_argument("-patients", default=False, action="store_true", dest="Patients", help="Set if you need to insert into Patients table")
parser.add_argument("-drugs",default=False,action="store_true",dest="Drugs",help="Set if you need to insert into Drugs table")
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
                    "Error Inserting into PatientInfo: One of hostname, username, password, database name, or patients flag is missing!")
                break

