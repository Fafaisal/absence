## About Absence
This project is based on https://github.com/tymondesigns/jwt-auth <br>
and for geotagging https://github.com/stevebauman/location

## Endpoints

<table>
  <tr>
    <td>Method</td>
    <td>Uri</td>
    <td>Descriptions</td>
  </tr>
  <tr>
    <td>POST</td>
    <td>api/register</td>
    <td>Create a new user account</td>
  </tr>
<tr>
    <td>POST</td>
    <td>api/login</td>
    <td>Authenticate user</td>
  </tr>
<tr>
    <td>POST</td>
    <td>api/absence-in</td>
    <td>User to absence in</td>
  </tr>
<tr>
    <td>POST</td>
    <td>api/absence-out</td>
    <td>User to absence out</td>
  </tr>
<tr>
    <td>POST</td>
    <td>api/get-absence</td>
    <td>Get absence by Id and date(today)</td>
  </tr>
</table>

## Examples
<ul><li>Register</li></ul>
<p>Uri : localhost:8000/api/register</p>
<pre>
Request Body :{
	"name":"Faisal",
	"userid":"20180309",
	"email":"test@gmail.com",
	"phone_number":"085692077xxx",
	"dept_id":"1",
	"gender":"M",
	"birthdate":"10-06-2001",
	"password":"123Abc",
	"password_confirmation":"123Abc"
}

Response Body :{
    "errorCode": "200",
    "errorDescription": "User Successfully Registered",
    "errorMessage": []
}</pre>
<br>

<ul><li>Login</li></ul>
<p>Uri : localhost:8000/api/login</p>

<pre>
localhost:8000/api/login

Request Body :{
	"email":"test@gmail.com",
	"password":"123Abc"
}

Response Body :{
    "errorCode": "200",
    "errorDescription": "Success",
    "data": {
        "name": "Faisal",
        "email": "test@gmail.com",
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTY0Mjk0MzA3MSwiZXhwIjoxNjQyOTQ2NjcxLCJuYmYiOjE2NDI5NDMwNzEsImp0aSI6IjlnUWJZVkhGVzRab002dzMiLCJzdWIiOjYsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.3SyXsl0SJrxTEzNX1jVXMnCO3ZSwvD_RU9DeyV8qNDI"
    }
}
</pre>
<br>

<ul><li>Absence In</li></ul>
<p>Uri : localhost:8000/api/absence-in</p>

<pre>
Request Body :{
	"userid":"20180309",
	"absence_in":"2022-01-23 07:58:25",
	"ip_address":"180.252.83.113",
	"img_selfie":"base64"
}

Response Body :{
    "errorCode": "200",
    "errorDescription": "Successfully Registered Absence In",
    "errorMessage": []
}
</pre>
<br>

<ul><li>Absence Out</li></ul>
<p>Uri : localhost:8000/api/absence-out</p>

<pre>
Request Body :{
	"absenceid":"2",
	"absence_out":"2022-01-23 18:58:25",
	"ip_address":"180.252.83.113",
	"img_selfie":"base64"
}

Response Body :{
    "errorCode": "200",
    "errorDescription": "Successfully Registered Absence Out",
    "errorMessage": []
}
</pre>
<br>


<ul><li>Get Absence by Id</li></ul>
<p>Uri : localhost:8000/api/get-absence</p>

<pre>

Request Body :{
	"id":"2"
}

Response Body :{
    "errorCode": "200",
    "errorDescription": "Success",
    "data": [
        {
            "absenceid": 2,
            "name": "Faisal",
            "userid": 20180309,
            "email": "test@gmail.com",
            "phone_number": "085692077010",
            "dep_name": "Accounting",
            "absence_in": "2022-01-23 07:58:25",
            "absence_out": "2022-01-23 18:58:25",
            "absence_sts": 1,
            "city_name": "Bogor",
            "region_name": "West Java",
            "country_code": "ID",
            "country_name": "Indonesia",
            "latitude": "-6.5945",
            "longitude": "106.789",
            "absence_desc": 1
        }
    ]
}
</pre>
<br>
