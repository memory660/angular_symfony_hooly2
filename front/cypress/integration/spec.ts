import * as societiesMock from '../mocks/societiesMocks';

describe('My First Test', () => {
  beforeEach(() => {
    cy.intercept('GET', '**/data/users', [{id: 3, username: "foodtrack1"}, {id: 4, username: "foodtrack2"}]);
    cy.intercept('GET', '**/data/societies', [{"id":1,"name":"society1"},{"id":2,"name":"society2"}]);
    cy.intercept('GET', '**/data/reservations/3/1', []);

  })

  it('Visits the initial project page', () => {
    cy.visit('/')


    let angular!: any;
    cy.window()
      .then((win) => angular = (win as any).ng)
      .then(() => cy.document())
      .then((doc) =>{
         const componentInstance = angular.getComponent(doc.querySelector('app-select-date'));
         cy.stub(componentInstance, 'now').returns(new Date('2022-04-09'));
         componentInstance.calculateDates();

         cy.byTestId('select-user')
         .first()
         .click().get('.mat-option-text')
         .should('contain', 'foodtrack1')
         .then(option => {option[0].click();})
         ;

         cy.byTestId('select-society')
         .first()
         .click()
         .get('.mat-option-text')
         .should('contain', 'society2')
         .then(option => {option[1].click();})

         cy.byTestId('date-picker')
         .first().clear().type('22/04/2022');


         cy.wait(1000);

         cy.byTestId('select-location')
         .first()
         .click()
         .get('.mat-option-text')
         .should('contain', '1')
         .then(option => {option[1].click();})

         cy.wait(1000);

         cy.byTestId('button-register').should('not.be.disabled');

      });

      console.log(cy.byTestId('select-user'))
  })
})
