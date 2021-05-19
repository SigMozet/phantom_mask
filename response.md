# Response
## API Document (required)
  請匯入[此網址](https://www.postman.com/collections/7f66a5adf078c5d5879c)至Postman，內有各API範例及錯誤回傳範例
  API的正確/錯誤回傳請詳見Postman

  ### 1.指定星期幾有營業之藥局
  [GET] /Pharmacies/openAtDay/{星期幾}
  {星期幾}請使用縮寫代號:Sun/Mon/Tue/Wed/Thu/Fri/Sat

  ### 2.指定星期幾且指定時間有營業之藥局
  [POST] /Pharmacies/openOnTime
  POST參數
  -    day指星期幾，請使用縮寫代號:Sun/Mon/Tue/Wed/Thu/Fri/Sat
  -    time請用HH:mm格式
  ```
  {
      "day":"Sat",
      "time":"07:21"
  }
  ```

  ### 3.查詢指定藥局販售之口罩
  [GET] /Pharmacies/getProduct/{{藥局ID}}

  ### 4.依照關鍵字查詢藥局名稱
  [GET] /Pharmacies/search/{{關鍵字}}

  ### 5.列出在價格區間內，該藥局的庫存大於或小於指定數量的藥局資料
  [POST] /Pharmacies/searchByPriceAndStock
  POST參數
  -    low，指價格下限，限INT
  -    high，指價格上限，限INT
  -    stocks_type，指大於或小於，請使用 more/less
  -    stocks_num，指庫存數量，限INT
  ```
  {
      "low":"10",
      "high":"20",
      "stocks_type":"more",
      "stocks_num":"10" 
  }
  ```

  ### 6.編輯藥局名稱
  [POST] /Pharmacies/editName
  POST參數
  -    id，藥局id，限INT
  -    name，藥局新名稱
  ```
  {
      "id" : 1,
      "name" : "Better You"
  }
  ```

  ### 7.依照關鍵字查詢口罩名稱
  [GET] /Masks/search/{{關鍵字}}

  ### 8.編輯口罩名稱
  [POST] /Masks/editName
  POST參數
  -    id，口罩id，限INT
  -    name，口罩新名稱
  ```
  {
      "mask_id" : 1,
      "new_name"    : "AniMask (blue) (10 per pack)"
  }
  ```

  ### 9.編輯口罩價格
  [POST] /Masks/editPrice
  POST參數
  -    id，口罩id，限INT
  -    price，口罩新價格
  ```
  {
      "mask_id" : 1,
      "price"    : "33.45"
  }
  ```

  ### 10.刪除口罩(soft delete)
  [POST] /Masks/deleteMask
  POST
  -    id，口罩id，限INT
  ```
  {
      "mask_id" : 3
  }
  ```

  ### 11.排序出指定時間內口罩交易量前x位的顧客
  [POST] /Transaction/RankUserByMaskAmount
  POST參數
  -    top_x，欲列出前x名顧客
  -    start_at，區間開始的時間點，請使用yyyy-mm-dd HH:mm
  -    end_at，區間結束的時間點，請使用yyyy-mm-dd HH:mm
  ```
  {
      "top_x" : 13,
      "start_at" : "2021-01-01 00:00",
      "end_at"   : "2021-01-31 23:59"
  }
  ```

  ### 12.指定時間內口罩交易總數
  [POST] /Transaction/RankUserByMaskAmount
  POST參數
  -    start_at，區間開始的時間點，請使用yyyy-mm-dd HH:mm
  -    end_at，區間結束的時間點，請使用yyyy-mm-dd HH:mm
  ```
  {
      "start_at" : "2021-01-01 00:00",
      "end_at"   : "2021-01-02 23:59"
  }
  ```

  ### 13.指定時間內交易總金額
  [POST] /Transaction/TotalValueInDateRange
  POST參數
  -    start_at，區間開始的時間點，請使用yyyy-mm-dd HH:mm
  -    end_at，區間結束的時間點，請使用yyyy-mm-dd HH:mm
  ```
  {
      "start_at" : "2021-01-01 00:00",
      "end_at"   : "2021-01-02 23:59"
  }
  ```

  ### 14.執行交易
  [POST] /Transaction/transaction
  POST參數
  phar_id，參與交易的藥局id，限INT
  mask_id，該藥局所販售的口罩id，限INT
  user_id，參與交易的顧客id，限INT
  ```
  {
      "phar_id" : 1,
      "mask_id" : 1,
      "user_id" : 1
  }
  ```

## Import Data Commands (required)
我沒有撰寫ETL相關的command，我透過PHP的guzzle套件將github上的data透過GET抓下來，
經過處理後存進SQL

## Test Coverage Report(optional)
  
  
## Demo Site Url (optional)
  程式目前部屬於Heroku上，網址為https://seanphantommask.herokuapp.com/
  可以直接透過Postman參照上方API文件進行測試

  亦可以在本地端使用Docker執行以下command，將程式在您本地端執行
  **備註:若使用Docker運行，請將Postman內的API domainw由 https://seanphantommask.herokuapp.com/ 更改為 127.0.0.1:8000**
  ```
  docker build -t=sean_project:latest .
  docker run --rm -it -p 8000:8000 sean_project:latest
  ```
  
