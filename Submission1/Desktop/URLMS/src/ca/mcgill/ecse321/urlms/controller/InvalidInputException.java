package ca.mcgill.ecse321.urlms.controller;

/**
 * Custom exception catching class for user invalid input
 * @author VictorVuong
 *
 */
public class InvalidInputException extends Exception {
	
	private static final long serialVersionUID = -5633915762703837868L;
	
	public InvalidInputException(String errorMessage) {
		super(errorMessage);
	}

}