import os

# Read messages from file
file_path = "messages.txt"

if os.path.exists(file_path):
    with open(file_path, "r") as file:
        print("Messages Received:\n")
        print(file.read())
else:
    print("No messages found.")