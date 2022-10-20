// fungsi untuk menampilkan huruf besar
String.prototype.capitalize = function() {
  return this.charAt(0).toUpperCase() + this.slice(1);
}

/**
 * Fungsi untuk read cookie
 * fungsi ini berhubungan dengan nexPref function yang menggunakan cookie
 */
function readCookie(name) {
  let nameEQ = name + "=";
  let ca = document.cookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

/**
 * fungsi untuk tombol next previous
 * sebelum digunakan deklarasikan variable indexOffset untuk offset record
 * deklarasikan variabel count untuk meperoleh jumlah record berdasarkan
 * menu item
 * (elmID )element id yang digunakan haya next dan previous
 * target id #mailing
 */
function nextPrev(elmID, routing, baseURL) {
  ((elmID == 'next') ? document.cookie = "logOffset=" + (indexOffset) + "; SameSite=None; Secure" : document.cookie = "logOffset=" + (indexOffset - 100) + "; SameSite=None; Secure");
  // let cookieValue = document.cookie.split(';');

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // let inboxOffset = cookieValue[0].substring(14);
  let inboxOffset = readCookie('logOffset');

  if (elmID == 'next') {
    if (indexOffset < count) {
      indexOffset = indexOffset;
    }
  } else if (elmID == 'previous') {
    if (indexOffset > 50) {
      indexOffset;
    }
  }

  if (inboxOffset >= 0 && (Math.floor(inboxOffset / count) <= 0)) {
    let link = baseURL;
    $.ajax({
      cache: false,
      url: routing,
      type: "POST",
      data: {
        offset: inboxOffset,
        limit: 50
      },
      dataType: 'json',
      success: (response) => {
        // console.log(response);

        $('#mailing').html("");

        $.each(response, (key, value) => {
          let star, read; 
          (value['star'] == 'star') ?  star = 'text-warning' : star = 'text-muted';
          (value['read'] == 'read') ? read = value['subject'] : read = "<b>" + value['subject'] + "</b>";
          
          $('#mailing').append(
            "<tr id=\"listingClicked\">" +
              "<td>" +
                "<div class=\"icheck-primary\">" +
                  "<input type=\"checkbox\" name=\"selection\" value=\"" + value['id'] + "\" id=\"check" + value['id'] + "\">" + 
                  "<label for=\"check" + value['id'] + "\"></label>" +
                "</div>" +
              "</td>" +
              "<td class=\"mailbox-star\">" +
                "<button type=\"button\" name=\"star[]\" class=\"btn btn-outline-secondary border-0\">" +
                  "<i class=\"fas fa-star " + star + "\"></i>" +
                "</button>" +
                "<input type=\"hidden\" name=\"ajxId\" value=\"" + value['id'] + "\" class=\"ajxId\">" +
              "</td>" +
              "<td class=\"mailbox-name\"><a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + value['name'].capitalize() + "</a></td>" +
              "<td class=\"mailbox-subject\">" +
                "<a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + 
                  read +
                "</a>" +
              "</td>" +
              "<td class=\"mailbox-attachment\"></td>" +
              "<td class=\"mailbox-date\">" +
                value['time'] + 
              "</td>" +
            "</tr>"
          );
        });

        if (elmID == 'next') {
          if (indexOffset < count) {
            indexOffset += 50;
          }
        } else if (elmID == 'previous') {
          if (indexOffset >= 50) {
            indexOffset -= 50;
          }
        }

        // console.log(indexOffset);

        $('.from').html("");
        let from = indexOffset - 49;
        let till = (indexOffset <= (count - 1) ) ? indexOffset : count;
        $('.from').html(from + "-" + till);
        
        starred(baseURL);
      }
    });
  }    
}
/**
 * untuk event delete 
 * name parameter digunakan untuk menentukan aksi yang digunakan
 * from parameter digunakan untuk menjelaskan dari mana halaman request berasal
 * routing merupakan ajax routing
 */
function checkedInput(name, from, routing) {
  let selectItem = [];
  $('input:checkbox[name=selection]:checked').each(function() {
    selectItem.push(parseInt($(this).val()));
  });
  
  // console.log(selectItem);

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  if (selectItem.length != 0) {
    $.ajax({
      cache: false,
      url: routing,
      type: "POST",
      data: {
        name: name,
        from: from,
        selection: selectItem
      },
      dataType: 'json',
      success: (response) => {
        // console.log(response);
        if (response.status == 'success') {
          toastr.success(response['message']);
          $('input:checkbox[name=selection]:checked').removeAttr('checked');
          $('#mark').html("<i class=\"far fa-square\"></i>");
          $('.to').html(response['count']);
          $('.inbox').html(response['inbox']);
          $('.drafts').html(response['drafts']);
          $('.trash').html(response['trash']);
        }
      }
    });
  }
}

/**
 * 
 * @param {*} baseURL 
 * baseURL merupakan url halaman dasar page
 * pada penggunaannya wajib terdapat button dengan nama array
 * fungsi harus diload di awal
 * fungsi inni juga digunakan pada fungsi lain untuk mengecek bintang pada pesan
 */
function starred(baseURL) {
  for (let i = 0; i < $('button[name="star[]"]').length; i++) {
    $('#listingClicked > td > button').eq(i).click(() => {
      // console.log($('#listingClicked > td > button').eq(i).children());
      let msgId = $('input[name="ajxId"]')[i].value;
      let target = $('#listingClicked > td > button').eq(i);

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        cache: false,
        url: baseURL + "/" + msgId + "/star",
        type: "get",
        data: 'json',
        success: (res) => {
          // console.log(res);
          target.html('');
          if (res['starred'] == 'star') {
            target.append(
              "<i class=\"fas fa-star text-warning\"></i>"
            );
          } else {
            target.append(
              "<i class=\"fas fa-star text-muted\"></i>"
            );
          }
        }
      });
    });
  }
}

function read(routing) {
  let selectItem = [];
  $('input:checkbox[name=selection]:checked').each(function() {
    selectItem.push(parseInt($(this).val()));
  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    cache: false,
    url: routing,
    type: "POST",
    data: {
      selection: selectItem
    },
    dataType: 'json',
    success: (response) => {
      // console.log(response);
      if (response.status == 'success') {
        toastr.success(response['message']);
      }
    }
  });
}

function reloding(baseURL, routing, targetCountRoute, name) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // console.log(indexOffset);
  let sendOffset;
  if (indexOffset == 50) {
    sendOffset = 0;
  } else {
    sendOffset = indexOffset - 50;
  }

  let link = baseURL;
  $.ajax({
    cache: false,
    url: routing,
    type: "POST",
    data: {
      offset: sendOffset,
      limit: 50
    },
    dataType: 'json',
    success: (response) => {
      // console.log(response);

      $('#mailing').html("");

      $.each(response, (key, value) => {
        let star, read; 
        (value['star'] == 'star') ?  star = 'text-warning' : star = 'text-muted';
        (value['read'] == 'read') ? read = value['subject'] : read = "<b>" + value['subject'] + "</b>";
        
        $('#mailing').append(
          "<tr id=\"listingClicked\">" +
            "<td>" +
              "<div class=\"icheck-primary\">" +
                "<input type=\"checkbox\" name=\"selection\" value=\"" + value['id'] + "\" id=\"check" + value['id'] + "\">" + 
                "<label for=\"check" + value['id'] + "\"></label>" +
              "</div>" +
            "</td>" +
            "<td class=\"mailbox-star\">" +
              "<button type=\"button\" name=\"star[]\" class=\"btn btn-outline-secondary border-0\">" +
                "<i class=\"fas fa-star " + star + "\"></i>" +
              "</button>" +
              "<input type=\"hidden\" name=\"ajxId\" value=\"" + value['id'] + "\" class=\"ajxId\">" +
            "</td>" +
            "<td class=\"mailbox-name\"><a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + value['name'].capitalize() + "</a></td>" +
            "<td class=\"mailbox-subject\">" +
              "<a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + 
                read +
              "</a>" +
            "</td>" +
            "<td class=\"mailbox-attachment\"></td>" +
            "<td class=\"mailbox-date\">" +
              value['time'] + 
            "</td>" +
          "</tr>"
        );
      });

      $('.from').html("");
      let from = indexOffset + 1;
      function checkCount() {
        $.ajax({
          cache: false,
          url: targetCountRoute,
          type: 'POST',
          data: {
            check: 'check inbox count',
            name: name
          },
          dataType: 'json',
          success: (res) => {
            // count = res['count'];
            // console.log(res);
            $('.to').html(res['count']);
            if (indexOffset == 0) {
              $('.from').html(from + "-" + 50);                
            } else {
              let till = (indexOffset <= (res['count'] - 1) ) ? indexOffset : res['count'];
              $('.from').html((from - 50) + "-" + till);
            }
          }
        })
      };

      checkCount();
      // console.log(count);
      
      starred(baseURL);
    }
  });
}

function nextPrevSent(elmID, routing, baseURL) {

  if (elmID == 'next') {
    if (Math.floor(indexOffset / 50) < Math.floor(count / 50)) {
      indexOffset += 50;
    } else if (indexOffset <= 0) {
      indexOffset = 0;
    }
  } else if (elmID == 'previous') {
    indexOffset -= 50
    if (indexOffset <= 0) {
      indexOffset = 0;
    }
  }

  // console.log(indexOffset - 50);

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (indexOffset >= 0 && (Math.floor(indexOffset / count) <= 0)) {
    let link = baseURL;
    $.ajax({
      cache: false,
      url: routing,
      type: "POST",
      data: {
        offset: indexOffset,
        limit: 50
      },
      dataType: 'json',
      success: (response) => {
        // console.log(response);

        $('#mailing').html("");

        $.each(response, (key, value) => {
          let star, read; 
          (value['star'] == 'star') ?  star = 'text-warning' : star = 'text-muted';
          (value['read'] == 'read') ? read = value['subject'] : read = "<b>" + value['subject'] + "</b>";
          
          $('#mailing').append(
            "<tr id=\"listingClicked\">" +
              "<td>" +
                "<div class=\"icheck-primary\">" +
                  "<input type=\"checkbox\" name=\"selection\" value=\"" + value['id'] + "\" id=\"check" + value['id'] + "\">" + 
                  "<label for=\"check" + value['id'] + "\"></label>" +
                "</div>" +
              "</td>" +
              "<td class=\"mailbox-star\">" +
                "<button type=\"button\" name=\"star[]\" class=\"btn btn-outline-secondary border-0\">" +
                  "<i class=\"fas fa-star " + star + "\"></i>" +
                "</button>" +
                "<input type=\"hidden\" name=\"ajxId\" value=\"" + value['id'] + "\" class=\"ajxId\">" +
              "</td>" +
              "<td class=\"mailbox-name\"><a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + value['name'].capitalize() + "</a></td>" +
              "<td class=\"mailbox-subject\">" +
                "<a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + 
                  read +
                "</a>" +
              "</td>" +
              "<td class=\"mailbox-attachment\"></td>" +
              "<td class=\"mailbox-date\">" +
                value['time'] + 
              "</td>" +
            "</tr>"
          );
        });

        $('.from').html("");
        let from = indexOffset + 1;
        let till = ((indexOffset + 50) <= (count - 1) ) ? (indexOffset + 50) : count;
        $('.from').html(from + "-" + till);
        
        starred(baseURL);
      }
    });
  }    
}

function refresh(baseURL, routing, targetCountRoute, name) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  let link = baseURL;
  $.ajax({
    cache: false,
    url: routing,
    type: "POST",
    data: {
      offset: indexOffset,
      limit: 50
    },
    dataType: 'json',
    success: (response) => {
      // console.log(response);

      $('#mailing').html("");

      $.each(response, (key, value) => {
        let star, read; 
        (value['star'] == 'star') ?  star = 'text-warning' : star = 'text-muted';
        (value['read'] == 'read') ? read = value['subject'] : read = "<b>" + value['subject'] + "</b>";
        
        $('#mailing').append(
          "<tr id=\"listingClicked\">" +
            "<td>" +
              "<div class=\"icheck-primary\">" +
                "<input type=\"checkbox\" name=\"selection\" value=\"" + value['id'] + "\" id=\"check" + value['id'] + "\">" + 
                "<label for=\"check" + value['id'] + "\"></label>" +
              "</div>" +
            "</td>" +
            "<td class=\"mailbox-star\">" +
              "<button type=\"button\" name=\"star[]\" class=\"btn btn-outline-secondary border-0\">" +
                "<i class=\"fas fa-star " + star + "\"></i>" +
              "</button>" +
              "<input type=\"hidden\" name=\"ajxId\" value=\"" + value['id'] + "\" class=\"ajxId\">" +
            "</td>" +
            "<td class=\"mailbox-name\"><a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + value['name'].capitalize() + "</a></td>" +
            "<td class=\"mailbox-subject\">" +
              "<a href=\"" + link + "/" + value['id'] + "/read" + "\" class=\"text-dark\">" + 
                read +
              "</a>" +
            "</td>" +
            "<td class=\"mailbox-attachment\"></td>" +
            "<td class=\"mailbox-date\">" +
              value['time'] + 
            "</td>" +
          "</tr>"
        );
      });

      $('.from').html("");
      let from = indexOffset + 1;
      function checkCount() {
        $.ajax({
          cache: false,
          url: targetCountRoute,
          type: 'POST',
          data: {
            check: 'check inbox count',
            name: name
          },
          dataType: 'json',
          success: (res) => {
            $('.to').html(res['count']);
            let till = 50;
            if (indexOffset == 0) {
              $('.from').html(from + "-" + till);
            } else if (Math.floor(indexOffset / 50) < Math.floor(count / 50)) {
              till = indexOffset + 50;
            } else {
              till = res['count'];
            }
            $('.from').html(from + "-" + till);
          }
        })
      };

      checkCount();
      // console.log(count);
      
      starred(baseURL);
    }
  });
}