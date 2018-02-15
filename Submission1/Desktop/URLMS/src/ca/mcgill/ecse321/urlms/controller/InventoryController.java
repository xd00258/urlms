package ca.mcgill.ecse321.urlms.controller;

import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.model.Equipment;
import ca.mcgill.ecse321.urlms.model.FundingAccount;
import ca.mcgill.ecse321.urlms.model.InventoryItem;
import ca.mcgill.ecse321.urlms.model.Lab;
import ca.mcgill.ecse321.urlms.model.SupplyType;
import ca.mcgill.ecse321.urlms.model.URLMS;

public class InventoryController extends Controller {
	/**
	 * This method will add an equipment to the inventory list
	 * 
	 * @param aName
	 *            of the item by String
	 * @param cost
	 *            of the item by double
	 * @throws InvalidInputException
	 */
	public void addEquipmentItem(String aName, String category, double cost) throws InvalidInputException {
		String error = "";

		if (aName == null || aName.isEmpty()) {
			error += "Please enter a name. ";
		}
		if (category == null || category.isEmpty()) {
			error += "Please enter a category. ";
		}
		if (cost < 0) {
			error += "Please enter a valid cost. ";
		}

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		try {
			Equipment temp = new Equipment(aName, cost, category, aLab, false);
			aLab.addInventoryItem(temp);
		} catch (RuntimeException e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	/**
	 * This method will add an item to the inventory list
	 * 
	 * @param name
	 *            of the item by String
	 * @param cost
	 *            of the item by double
	 * @param category
	 *            of item by String
	 * @throws InvalidInputException
	 */
	public void addInventoryItem(String name, double cost) throws InvalidInputException {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);

		try {
			aLab.addInventoryItem(name, cost, null);
		} catch (RuntimeException e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	/**
	 * This method will add a supply type to the inventory list
	 * 
	 * @param aName
	 *            of the item by String
	 * @param cost
	 *            of the item by double
	 * @param quantity
	 *            of item by int
	 * @throws InvalidInputException
	 */
	public void addSupplyItem(String aName, String category, double cost, int quantity) throws InvalidInputException {
		String error = "";
		
		if (aName == null || aName.isEmpty()) {
			error += "Please enter a name. ";
		}
		if (category == null || category.isEmpty()) {
			error += "Please enter a category. ";
		}
		if (cost < 0) {
			error += "Please enter a valid cost. ";
		}
		if (quantity <= 0) {
			error += "Please enter a valid quantity. ";
		}
		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}

		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		try {
			SupplyType temp = new SupplyType(aName, cost, category, aLab, quantity);
			aLab.addInventoryItem(temp);
		} catch (RuntimeException e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	/**
	 * This method will edit the details of a specific item inventory
	 * 
	 * @param name
	 *            of the the inventory item by String
	 * @throws InvalidInputException
	 */
	public void editInventoryItemDetails(String oldName, String desiredName, String desiredCategory, double desiredCost,
			int desiredQuantity) throws InvalidInputException {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		String error = "";
		InventoryItem foundItem = null;
		
		
		if (oldName == null || oldName.isEmpty()) {
			error += "Please enter the existing item name. ";
		}
		if (desiredName == null || desiredName.isEmpty()) {
			error += "Please enter a new name. ";
		}
		if (desiredCategory == null || desiredCategory.isEmpty()) {
			error += "Please enter a category. ";
		}
		if (desiredCost < 0) {
			error += "Please enter a valid cost. ";
		}


		List<InventoryItem> items = aLab.getInventoryItems();
		for (InventoryItem anItem : items) {
			if (anItem.getName().equals(oldName)) {
				foundItem = anItem;
				break;
			}
		}
		
		if (desiredQuantity == Integer.MIN_VALUE){ //user left the field blank
			if(foundItem != null){ //if not null. If null will get taken care after
				if(foundItem instanceof SupplyType){ //not supposed to have blank quantity
					error += "Do not leave the quantity field blank. ";
				}
				else if(foundItem instanceof Equipment){
					//stuff is good since no quantity for equipment 
				}
				else{ //not supposed to happen
					error += "stuff happened. ";
				}
			}
		}
		else if (desiredQuantity <= 0) {
			error += "Please enter a valid quantity. ";
		}

		if (foundItem == null) {
			error += "Requested inventory item not found :( ";
		}

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}

		try {
			if (foundItem instanceof SupplyType) {
				SupplyType temp = (SupplyType) foundItem;
				temp.setName(desiredName);
				temp.setCategory(desiredCategory);
				temp.setCost(desiredCost);
				temp.setQuantity(desiredQuantity);
			} else { // must be Equipment(?)
				Equipment temp = (Equipment) foundItem;
				temp.setName(desiredName);
				temp.setCategory(desiredCategory);
				temp.setCost(desiredCost);
			}
		} catch (RuntimeException e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	/**
	 * This method is a helper method to check if an item is an equipment
	 * @param index of the item in the list
	 * @return true if the item is an equipment, false otherwise
	 */
	public boolean inventoryItemIsEquipment(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		if (aLab.getInventoryItem(index) instanceof Equipment) {
			return true;
		} else
			return false;
	}

	/**
	 * This method is helper method to check if an item is a supply
	 * @param index of the item in the list
	 * @return true if the item is a supply, false otherwise
	 */
	public boolean inventoryItemIsSupply(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		if (aLab.getInventoryItem(index) instanceof SupplyType) {
			return true;
		} else
			return false;
	}

	/**
	 * This method will remove an item from the inventory list
	 * 
	 * @param index of Inventory Item by int
	 */
	public void removeInventoryItem(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		aLab.getInventoryItem(index).delete();
	}
	
	/**
	 * This method will remove an item from the inventory list
	 * 
	 * @param index of Inventory Item by int
	 * @throws InvalidInputException 
	 */
	public void removeInventoryItembyName(String name) throws InvalidInputException {
		String error = "";
		InventoryItem foundItem = null;
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		
		List<InventoryItem> items = aLab.getInventoryItems();
		for (InventoryItem anItem : items) {
			if (anItem.getName().equals(name)) {
				foundItem = anItem;
				break;
			}
		}
		
		if (foundItem == null) {
			error += "Requested inventory item not found :( ";
		}

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}
		
		foundItem.delete();
	}

	/**
	 * This method will get the cost of an inventory item.
	 * @param index of the item in the list
	 * @return the cost of the item as a String
	 */
	public String viewInventoryItemCost(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		return String.valueOf(aLab.getInventoryItem(index).getCost());
	}

	/**
	 * This method will get the name of an inventory item.
	 * @param index of the item in the list
	 * @return the name of the item as a String
	 */
	public String viewInventoryItemName(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		return aLab.getInventoryItem(index).getName();
	}

	/**
	 * This method will get the inventory item list
	 * 
	 * @return a list of the inventory items
	 * @throws InvalidInputException
	 */
	public List<InventoryItem> viewInventoryList() throws InvalidInputException {
		String error = "";

		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);

		List<InventoryItem> inventorylist;

		try {
			inventorylist = aLab.getInventoryItems();
			if (inventorylist.isEmpty()) {
				error = "There are no inventory items to display :( ";
			}
			if (error.length() > 0) {
				throw new InvalidInputException(error);
			}
		} catch (RuntimeException e) {
			throw new InvalidInputException(e.getMessage());
		}
		return inventorylist;
	}

	/**
	 * This method will get the quantity of a supply item in the lab.
	 * @param index of the item in the list
	 * @return the quantity of the supply item as a String
	 */
	public String viewSupplyItemQuantity(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		if (aLab.getInventoryItem(index) instanceof SupplyType) {
			SupplyType temp = (SupplyType) aLab.getInventoryItem(index);
			return String.valueOf(temp.getQuantity());
		} else {
			return "N/A";
		}
	}

}
