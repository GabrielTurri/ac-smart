import { createGlobalStyle } from "styled-components";

export const GlobalStyle = createGlobalStyle`
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}


body {
  background: ${props => props.theme['blue-100']};
  color: ${props => props.theme['blue-900']};
}

body, input, textarea, button {
  font-family: "Montserrat", sans-serif;
  font-weight: 400;
  font-style: 1rem;
}


`
