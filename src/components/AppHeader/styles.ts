import styled from "styled-components";

export const HeaderContainer = styled.div`
  display: flex;
  gap: 16px;
  padding: 8px;
  margin: 0;

  justify-content: space-between;
  
  background-color: ${props => props.theme['blue-500']};
  color: #fff;
  
  
  h2 {
    font-weight: 400;
    /* font-family: Montserrat, sans-serif; */ 
  }
  
  a {
    text-decoration: none;
    color: #fff;
  }
`;