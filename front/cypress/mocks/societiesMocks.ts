export const getSocieties = () => {
  let endPoint ='/api/societies';

  cy.route({
    method: 'GET',
    url: `${endPoint}`
  })
}
