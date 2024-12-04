// document.addEventListener("DOMContentLoaded", function () {
//     const generateButton = document.getElementById("generate-store");
//     const randomStoreDiv = document.getElementById("random-store");

//     generateButton.addEventListener("click", function() {
//         const xhr = new XMLHttpRequest();
//         xhr.open("GET", "../controllers/StoreController.php?action=getRandomStore", true);
//         xhr.setRequestHeader("Accept", "application/json");

//         xhr.onload = function() {
//             if (xhr.status === 200) {
//                 const data = JSON.parse(xhr.responseText);

//                 if (data.error) {
//                     randomStoreDiv.innerHTML = `<p>${data.error}</p>`;
//                 } else {
//                     randomStoreDiv.innerHTML = `
//                         <h4>Random Thrift Store</h4>
//                         <p><strong>Name:</strong> ${data.store_name}</p>
//                         <p><strong>Address:</strong> ${data.store_address}</p>
//                     `;
//                 }
//             } else {
//                 alert("Error fetching random store.");
//             }
//         };

//         xhr.send();
//     });
// });
