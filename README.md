# Charging Stations

## URLs
instance url: https://has-to-be-uouflyqo5a-ew.a.run.app/ \
admin url: https://has-to-be-uouflyqo5a-ew.a.run.app/admin \
api url: https://has-to-be-uouflyqo5a-ew.a.run.app/api

## GET requests
get all charging stations: https://has-to-be-uouflyqo5a-ew.a.run.app/api/stations \
get a charging station detail: https://has-to-be-uouflyqo5a-ew.a.run.app/api/stations/{ID} \
get a charging station's status for current or selected time: https://has-to-be-uouflyqo5a-ew.a.run.app/api/stations/{ID}/open \
get a charging station's next status change for current or selected time: https://has-to-be-uouflyqo5a-ew.a.run.app/api/stations/{ID}/status_change

### select a custom date
send the request with body containing date
```json
{
    "date": "2020-09-04 7:30:00"
}
```