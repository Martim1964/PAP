# Feature: Registe Screen

#   Scenario: I am in the regist screen
#     Given I go to the regist page
#     Then I should see the regist page


#####################################################################
# Regist test(A-001)
##################################################################

# Feature: Regist an user

# Scenario: Successful registration
#     Given I am on the home page
#     When I click on "Login/Registe-se"
#     And I am in the login page
#     And I click in "Registe-se aqui"
#     And I am in the regist page
#     And I insert the "Tininho Test" name
#     And I insert the "Tininho@gmail.com" email
#     And I insert the "TininhoTest" password
#     And I confirm that "TininhoTest" password
#     And I insert my "995838770" phone number
#     And I insert my "24/07/2007" date of birth
#         And I click in the regist button
#             Then I should go to the login page





# ######################################################################
# #Login test(A-002)
# ###################################################################

# Feature: Login the user

# Scenario: Successful login
#     Given I am on the login page
#     When I insert the "Tininho@gmail.com" email
#     And I insert the "TininhoTest" password
#         And I Click in the login button
#             Then I should be redirected to the main page
#             And the navbar should display "Bem-vindo, Tininho Test!"




# ######################################################################
# #Cart system test(A-003)
# ###################################################################

# Feature: Insert a product in cart

# Scenario: Product in cart
#     Given I am logged in
#     And I am on the main page
#     When I click in the dropdown button "Nossos Bolos"
#     And I click on the "Bolos de aniversário" cake section
#     And I am in the page of that section
#     And I click in "Encomendar / Personalizar" of a cake
#     And I see the page of that cake
#     And I open the dropdown button "Escolha um tamanho"
#     And I open the dropdown button "Escolha uma massa"
#     And I open the dropdown button "Escolha um recheio"
#     And I put the date "06/06/2027" of the event
#     And I click in the button "Adicionar ao Carrinho"
#     And I am in the cart page
#     And I click in the button "Finalizar Compra"
#     And I see a page with my user data and the product I want
#     And I click in the CheckBox saying "Concordo com os Termos de Condiçoes e Política de privacidade"
#         And I click in the button "Avançar para pagamento"
#             Then I should be redirected to the Stripe checkout





# ######################################################################
# #Cake section test(A-004)
# ###################################################################

# Feature: Cake products validation

# Scenario: Verify if all products are displayed
#     Given I am on the main page
#     When I click in the dropdown button "Nossos Bolos"
#     And I click on the "Bolos de aniversário" cake section
#         Then I should be redirected to the page of that section
#         And I see a list of products
#         And I see the name of the products, price and an image






# ######################################################################
# #Login Failed test(A-005)
# ###################################################################

# Feature: Login with invalid credentials

# Scenario: Failed login
#     Given I am on the login page
#     And I insert the "Tininho.234@gmail.com" email
#     And I insert the "TininhoFalse" password
#         When I Click in the login button
#             Then I should see an error message


# ######################################################################
# #Login SQLInjection test(A-006)
# ###################################################################

Feature: Login with SQLInjection data

Scenario: Failed login SQL Injection
    Given I am on the login page
    And I insert the "'OR'1'='1--@email.com" email   
    And I insert the "TininhoFalse" password
        When I Click in the login button
            Then I should see an error message