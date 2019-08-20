## Solodev App Structure
In order to import this application into Solodev it must go through the package import process. The structure below assumes that you take this repository and zip the files into a file named 'app.zip'. The sample structure of a package that just contains this app is below:

```
/package.zip
	/THIS REPOSITORY/	
	/app.zip
	/config.json
```
        
## config.json
The config.json file must contain the following markup. The package variables ("<!app_name!>" and "<!app_section!>") will be overwritten by the user upon installation.

```
{
	"App_View": [{
		"name": "<!app_name!>",
		"nav_icon": "fas fa-flag",
		"from_path": "/app.zip",
		"parent_id": "<!app_section!>"
  }]
}
```