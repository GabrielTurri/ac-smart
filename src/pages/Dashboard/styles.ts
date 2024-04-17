import styled from "styled-components";

export const AppHeader = styled.div`
  background-color: ${props => props.theme['blue-500']};
  padding: 8px;
`;

export const DashboardContainer = styled.div`
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 32px;
  /* align-items: center; */
  justify-content: center;

  width: (100vw) ;
  margin: 0 64px;
  `;

export const ChartContainer = styled.div`
  min-width: 20rem;
  width: 40%;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  text-align: center;
  align-items: center;
  padding: 40px;
  gap: 8px;

  border: 0.5px solid ${props => props.theme['blue-300']};
  border-radius: 24px;
`;

export const Button = styled.button`
  display: flex;
  flex-direction: row;
  gap: 8px;
  justify-content: center;
  align-items: center;

  width: 100%;

  border: none;
  border-radius: 12px;
  padding: 16px;
  background-color: ${props => props.theme['blue-300']};
  font-weight: bold;
  color: #fff;
  font-size: 18px;

  cursor: pointer;
`;

export const ChartImg = styled.div`
  width: 148px;
  height: 148px;
  background-color: ${props => props.theme['blue-300']};
`;