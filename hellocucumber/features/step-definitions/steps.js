const { Given, When, Then } = require('@wdio/cucumber-framework');

// Centralized selectors object
const selectors = {
  // All the selectors used here

  // Navbar Selectors
  NavbarLoginRegist: '[aria-label="Abrir página de login ou registo"]',
  NavbarNossosBolos: '[aria-label="Abrir menu Nossos Bolos"]',
  NavbarLoginName: '[aria-label="Abrir menu da conta"]',

  // Cake Categories Submenu
  WeddingCakes: '[aria-label="Casamento"]',
  BirthdayCakes: '[aria-label="Aniversário"]',
  BaptismCakes: '[aria-label="Batizados"]',
  CupcakesAndSweets: '[aria-label="Cupcakes/Doces"]',

  // Products List
  ProductList: '[aria-label="Product List"]',
  ProductCard: '[aria-label="Product Card"]',
  ContentCard: '[aria-label = "Cake Content"]',
  CakeOrderBtn: '[aria-label="Encomendar bolo"]',

  // CakeOrderPage
  SizeSelectCakes: '[aria-label="Tamanho"]',
  BatterSelectCakes: '[aria-label="Massa"]',
  FillingSelectCakes: '[aria-label="Recheio"]',
  DateSelectCakes: '[aria-label="Event Date"]',
  CartAddBtn: '[aria-label="Add to Cart"]',

  // Cart Page
  FinishBtn: '[aria-label="Finalizar Compra"]',

  // Finish Purchase Page
  TermsCheckBox: '[aria-label="Termos e Condicoes"]',
  AdvanceBtn: '[aria-label="Avançar"]',

  // Login Page Selectors
  RegisterHereLink: '[aria-label="Registe-se aqui"]',
  EmailInputLogin: '[aria-label="Email"]',
  PasswordInputLogin: '[aria-label="Password"]',
  LoginBtn: '[aria-label="Enter Button"]',
  LoginError: '[aria-label="Mensagem de Erro"]',

  // Regist Page Selectors
  FullNameInput: '[aria-label="Full Name"]',
  EmailInputRegist: '[aria-label="Email Adress"]',
  PasswordInputRegist: '[aria-label="Password"]',
  ConfirmPasswordInput: '[aria-label="Confirm Password"]',
  PhoneInput: '[aria-label="Phone Number"]',
  BirthDateInput: '[aria-label="Date of Birth"]',
  RegisterBtn: '[aria-label="Register button"]',
};

// // ///////////////////////////////////////////////////////////////////////
// // 1. Regist Test
// // //////////////////////////////////////////////////////////////////////
// Given('I am on the home page', async () => {
//   await browser.url('http://localhost/PAP/index.php');
//   await browser.maximizeWindow();
// });

// When('I click on {string}', async (linkName) => {
//   if (linkName === 'Login/Registe-se') {
//     const LoginNav = await $(selectors.NavbarLoginRegist);
//     await LoginNav.click();
//   } else {
//     throw new Error(`Step handler not implemented for click target: ${linkName}`);
//   }
// });

// When('I am in the login page', async() => {
//   await expect(browser).toHaveUrl('http://localhost/PAP/pages/login.php');
// });

// When('I click in {string}', async (linkName) => {
//   if (linkName === 'Registe-se aqui') {
//     const RegistLink = await $(selectors.RegisterHereLink);
//     await RegistLink.click();
//   } else {
//     throw new Error(`Step handler not implemented for click target: ${linkName}`);
//   }
// });

// When('I am in the regist page', async() => {
//   await expect(browser).toHaveUrl('http://localhost/PAP/pages/regist.php');
// });

// When('I insert the {string} name', async(name) => {
//   const NameField = await $(selectors.FullNameInput);
//   await NameField.setValue(name);
// });

// When('I insert the {string} email', async(email) => {
//   const EmailField = await $(selectors.EmailInputRegist);
//   await EmailField.setValue(email);
// });

// When('I insert the {string} password', async(password) => {
//   const PassField = await $(selectors.PasswordInputRegist);
//   await PassField.setValue(password);
// });

// When('I confirm that {string} password', async(confirmPassword) => {
//   const ConfPassField = await $(selectors.ConfirmPasswordInput);
//   await ConfPassField.setValue(confirmPassword);
// });

// When('I insert my {string} phone number', async(phoneNumber) => {
//   const PhoneField = await $(selectors.PhoneInput);
//   await PhoneField.setValue(phoneNumber);
// });

// When('I insert my {string} date of birth', async(birthDate) => {
//   const birthField = await $(selectors.BirthDateInput);
//   await birthField.setValue(birthDate);
// });

// When('I click in the regist button', async() =>{
//   const RegistBtn = await $(selectors.RegisterBtn);
//   await RegistBtn.click();
// });

// Then("I should go to the login page", async() =>{
//   await expect(browser).toHaveUrl('http://localhost/PAP/pages/login.php');
// });



// // ///////////////////////////////////////////////////////////////////////
// // 2. Login Test AND Login Failed Test AND SQLInjection Test
// // //////////////////////////////////////////////////////////////////////
Given('I am on the login page', async() =>{
  browser.url('http://localhost/PAP/pages/login.php');
  await browser.maximizeWindow();
});

When('I insert the {string} email', async(email) =>{
  emailLog = await $(selectors.EmailInputLogin);
  await browser.pause(500);
  await emailLog.setValue(email);
});

When ('I insert the {string} password', async(password) =>{
  passLog = await $(selectors.PasswordInputLogin);
  await browser.pause(500);
  await passLog.setValue(password);
});

When ('I Click in the login button', async() =>{
  btnLog = await $(selectors.LoginBtn);
  await browser.pause(500);
  await btnLog.click();
});

// Then('I should be redirected to the main page', async() =>{
//   await expect(browser).toHaveUrl('http://localhost/PAP/index.php');
// });

// Then('the navbar should display {string}', async (text) => {
//     const userDisplay = await $(selectors.NavbarLoginName); 
//     await userDisplay.waitForDisplayed({ timeout: 5000 });
//     await expect(userDisplay).toHaveText(expect.stringContaining(text));
// });


//To test with invalid credentials
Then('I should see an error message', async() =>{
  LogError = await $(selectors.LoginError);
  await browser.pause(500);
  await LogError.isDisplayed();
})

// ///////////////////////////////////////////////////////////////////////
// 3. Cart system Test
// //////////////////////////////////////////////////////////////////////

// Given('I am logged in', async () => {
//   await browser.url('http://localhost/PAP/pages/login.php');

//   await $(selectors.EmailInputLogin).setValue('Tininho@gmail.com');
//   await $(selectors.PasswordInputLogin).setValue('TininhoTest');
//   await $(selectors.LoginBtn).click();

//   await expect(browser).toHaveUrl('http://localhost/PAP/index.php');
// });

// Given('I am on the main page', async() =>{
//   browser.url('http://localhost/PAP/index.php');
//   await browser.maximizeWindow();
// });

// When('I click in the dropdown button {string}', async(text) =>{
//   btnSections = await $(selectors.NavbarNossosBolos);
//   await btnSections.click();
// });

// When('I click on the {string} cake section', async(text) => {
//   const btnCakeSection = await $(selectors.BirthdayCakes);
//   await btnCakeSection.click();
// })

// When ('I am in the page of that section', async() =>{
//   await expect(browser).toHaveUrl('http://localhost/PAP/pages/bolos/aniversario.php');
// })

// When('I click in {string} of a cake', async(text) =>{
//   const cakes = await $$(selectors.CakeOrderBtn);
//   await cakes[1].click();
// })

// When('I see the page of that cake', async() =>{
//   await expect(browser).toHaveUrl(expect.stringContaining('encomenda.php'));
// })

// When('I open the dropdown button {string}', async (dropdownName) => {
//     if (dropdownName === "Escolha um tamanho") {
//         await $(selectors.SizeSelectCakes).selectByIndex(1);
//     } else if (dropdownName === "Escolha uma massa") {
//         await $(selectors.BatterSelectCakes).selectByIndex(1);
//     } else if(dropdownName == "Escolha um recheio"){
//       await $(selectors.FillingSelectCakes).selectByIndex(1);
//     }
// });

// When('I put the date {string} of the event', async(eventDate) =>{
//   const Eventdate = await $(selectors.DateSelectCakes);
//   await Eventdate.setValue(eventDate);
// })

// When('I click in the button {string}', async (buttonName) => {
//     if (buttonName === "Adicionar ao Carrinho") {
//         const addCart = await $(selectors.CartAddBtn);
//         await addCart.click();
//     } else if (buttonName === "Finalizar Compra") {
//         const finishBuy = await $(selectors.FinishBtn);
//         await finishBuy.click();
//     } else if(buttonName == "Avançar para pagamento"){
//       const btnPayment = await $(selectors.AdvanceBtn);
//       await btnPayment.click();
//     }
// });

// When('I am in the cart page', async() =>{
//   await expect(browser).toHaveUrl('http://localhost/PAP/pages/compras.php');
// })

// When('I see a page with my user data and the product I want', async() =>{
//   await expect(browser).toHaveUrl('http://localhost/PAP/pages/compras-finalizar.php');
// })

// When('I click in the CheckBox saying {string}', async(text) =>{
//   const cbTerms = await $(selectors.TermsCheckBox);
//   await cbTerms.click();
// })

// Then('I should be redirected to the Stripe checkout', async() =>{
//   await expect(browser).toHaveUrl(expect.stringContaining('stripe.com'));
// })


// ///////////////////////////////////////////////////////////////////////
// 4. Cake products validation
// //////////////////////////////////////////////////////////////////////

// Given('I am on the main page', async() =>{
//   await browser.url('http://localhost/PAP/index.php');
//   await browser.maximizeWindow();
// })

// When('I click in the dropdown button {string}', async(text) =>{
//   btnCakes = await $(selectors.NavbarNossosBolos);
//   await btnCakes.click();
// })

// When('I click on the {string} cake section', async(text) => {
//   btnSection = await $(selectors.BirthdayCakes);
//   await btnSection.click();
// })

// Then('I should be redirected to the page of that section', async() =>{
//   await expect(browser).toHaveUrl('http://localhost/PAP/pages/bolos/aniversario.php');
// })

// Then('I see a list of products', async() =>{
//   List = await $$(selectors.ProductList);
//   await expect(List).toBeDisplayed;
// })

// Then('I see the name of the products, price and an image', async() =>{
//   btnProductCard = await $(selectors.ContentCard);
//   await expect(btnProductCard).toBeDisplayed();
// })


