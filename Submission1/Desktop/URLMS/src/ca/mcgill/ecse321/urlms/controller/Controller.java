package ca.mcgill.ecse321.urlms.controller;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;

public class Controller {

	/**
	 * This method calls the save method from the application to save the
	 * current urlms to the persistence.
	 */
	public void save() {
		URLMSApplication.save();
	}

}
