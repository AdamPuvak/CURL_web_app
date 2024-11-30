<a id="readme-top"></a>

<!-- HEADER -->
<div align="center">
  <h3 align="center">CURL website</h1>
  <p align="center">
    Website extracting educational data through CURL requests.
  </p>
</div>

<!-- ABOUT THE PROJECT -->
## About The Project

This web service allows students to fetch and manage their personal schedule and thesis topics from university information system through CURL requests and provide an API for further access.
Key features of the project include:

## Schedule Information
### Fetch Schedule with CURL:
A button is provided on the webpage that, upon clicking, uses a CURL request to retrieve the student’s personal schedule from the university information system.
This data is then stored in a database for further management.

Another button is available to clear all the schedule data from the database.

### Schedule Management API:
**GET:** Retrieve all schedule events (including day of the week, event type, subject name, and location). The data is provided in JSON format.

**POST:** Create a new schedule event, such as a lecture or lab session.

**DELETE:** Delete a specific schedule event.

**PUT:** Modify an existing schedule event (e.g., change subject name, time, or location).

## Thesis Topics Information
### Fetch Thesis Topics with CURL:
Data is fetched from the university information system website for thesis topics across various departments.

### API for Available Thesis Topics:
**GET:** Display available (unassigned) thesis topics for a selected department and study program.

The API returns details such as the thesis title, supervisor name, department, program, specialization, and the abstract.

### Webpage Interaction:
The webpage allows students to view available thesis topics for a selected department and study program.
The list is sortable and filterable by supervisor and study program.

Clicking on a thesis title will show its abstract.

A search feature is included to filter topics based on keywords in the title or abstract.

## Web Service Implementation
The web service is built using REST API, following the principles of REST. It provides endpoints for accessing schedule data, adding or deleting schedule events, and viewing available thesis topics.

Error Handling: Proper error handling is implemented, ensuring correct HTTP status codes (200, 400, etc.) are returned based on the outcome of the request.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- TOOLS -->
### Built With

* [![PHP][PHP.com]][PHP-url]
* [![HTML][HTML.com]][HTML-url]
* [![CSS][CSS.com]][CSS-url]
* [![JavaScript][JS.com]][JS-url]
* [![CURL][CURL.com]][CURL-url]
* [![REST API][REST-url]][REST-url]
* [![SQL][SQL.com]][SQL-url]
* [![DataTables][DataTables.com]][DataTables-url]
* [![JSON][JSON.com]][JSON-url]
* [![jQuery][jQuery.com]][jQuery-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- LINKS -->
[HTML.com]: https://img.shields.io/badge/HTML-E34F26?style=for-the-badge&logo=html5&logoColor=white
[HTML-url]: https://developer.mozilla.org/en-US/docs/Web/HTML
[CSS.com]: https://img.shields.io/badge/CSS-1572B6?style=for-the-badge&logo=css3&logoColor=white
[CSS-url]: https://developer.mozilla.org/en-US/docs/Web/CSS
[JS.com]: https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black
[JS-url]: https://developer.mozilla.org/en-US/docs/Web/JavaScript
[PHP.com]: https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
[PHP-url]: https://www.php.net/
[SQL.com]: https://img.shields.io/badge/SQL-006B3F?style=for-the-badge&logo=sql&logoColor=white
[SQL-url]: https://www.mysql.com/
[DataTables.com]: https://img.shields.io/badge/DataTables-1A82FF?style=for-the-badge&logo=datatables&logoColor=white
[DataTables-url]: https://datatables.net/
[CURL.com]: https://img.shields.io/badge/CURL-3BB9FF?style=for-the-badge&logo=curl&logoColor=white
[CURL-url]: https://curl.se/
[JSON.com]: https://img.shields.io/badge/JSON-000000?style=for-the-badge&logo=json&logoColor=white
[JSON-url]: https://www.json.org/json-en.html
[REST-url]: https://img.shields.io/badge/REST-5A2C79?style=for-the-badge&logo=rest&logoColor=white
[REST-url]: https://restfulapi.net/
[jQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[jQuery-url]: https://jquery.com/


### Created
2024
