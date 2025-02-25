import json
import bcrypt

USER_DB = "users.json"

def load_users():
    try:
        with open(USER_DB, "r") as file:
            return json.load(file)
    except (FileNotFoundError, json.JSONDecodeError):
        return {}

def save_users(users):
    with open(USER_DB, "w") as file:
        json.dump(users, file, indent=4)

def register(username, password):
    users = load_users()
    if username in users:
        print("Username already exists!")
        return False
    hashed_password = bcrypt.hashpw(password.encode(), bcrypt.gensalt()).decode()
    users[username] = hashed_password
    save_users(users)
    print("User registered successfully!")
    return True

def login(username, password):
    users = load_users()
    if username not in users:
        print("User not found!")
        return False
    if bcrypt.checkpw(password.encode(), users[username].encode()):
        print("Login successful!")
        return True
    else:
        print("Invalid password!")
        return False

if __name__ == "__main__":
    while True:
        action = input("Choose an action (register/login/exit): ").strip().lower()
        if action == "register":
            user = input("Enter username: ")
            pwd = input("Enter password: ")
            register(user, pwd)
        elif action == "login":
            user = input("Enter username: ")
            pwd = input("Enter password: ")
            login(user, pwd)
        elif action == "exit":
            break
        else:
            print("Invalid action. Try again.")