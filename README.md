# Events Management System

## Abstract
The College Events Management System is a web-based application designed to simplify the organization, management, and participation in college events...

## Features
### Administrator Features
- Add, edit, delete events
- Upload event images
- View registrations
- Track payment status

### Student Features
- View upcoming events
- Register or cancel registration
- Check payment status

## Database Tables
### users
| Column   | Type | Description |
|----------|------|-------------|
| id       | INT PK AI | Unique ID |
| name     | VARCHAR(50) | Full name |
| email    | VARCHAR(50) | Unique email |
| password | VARCHAR(255) | Hashed password |
| role     | ENUM('admin','student') | User role |

### events
| Column      | Type | Description |
|-------------|------|-------------|
| id          | INT PK AI | Unique ID |
| title       | VARCHAR(100) | Event title |
| description | TEXT | Event description |
| date        | DATE | Event date |
| time        | TIME | Event time |
| location    | VARCHAR(100) | Event location |
| image       | VARCHAR(100) | Image filename |

### registrations
| Column      | Type | Description |
|-------------|------|-------------|
| id          | INT PK AI | Unique ID |
| student_id  | INT FK | Reference to users.id |
| event_id    | INT FK | Reference to events.id |
| paid        | ENUM('yes','no') | Payment status |

## Technologies Used
- PHP, MySQL, HTML, CSS, JavaScript
- WAMP Server
- Git & GitHub

