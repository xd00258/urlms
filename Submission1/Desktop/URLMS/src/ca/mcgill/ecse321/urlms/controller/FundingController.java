package ca.mcgill.ecse321.urlms.controller;

import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.model.Expense;
import ca.mcgill.ecse321.urlms.model.FinancialReport;
import ca.mcgill.ecse321.urlms.model.FundingAccount;
import ca.mcgill.ecse321.urlms.model.Lab;
import ca.mcgill.ecse321.urlms.model.URLMS;

public class FundingController extends Controller {

	public FundingController() {
	}

	//--------------------- USE CASES IMPLEMENTATION --------------------------

	/**
	 * This method is used to add funds to a specific funding account in the lab
	 * @param index of the funding account in the account list
	 * @param amount of fund to add
	 */

	public void addFunding(int index, double amount) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		double currentBalance = aLab.getFundingAccount(index).getBalance();
		aLab.getFundingAccount(index).setBalance(currentBalance + amount);
	}

	/**
	 * This method will add a new funding account to the lab with an initial balance
	 * @param fundingType name of the account
	 * @param fundingBalance balance of the account
	 * @throws InvalidInputException
	 */
	public void addFundingAccount(String fundingType, double fundingBalance) throws InvalidInputException {
		String error = "";

		if (fundingType == null || fundingType.isEmpty()) {
			error += "Please enter a name for the account. ";
		}

		// Assuming that you can start with negative balance
		// So no exception handling for that case

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}

		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		try {
			aLab.addFundingAccount(fundingType, fundingBalance);
		} catch (RuntimeException e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	
	/**
	 * This method will add a transaction to a funding account. The transaction must have a date
	 * amount and type name.
	 * @param date of the transaction
	 * @param amount of money of the transaction
	 * @param type of transaction aka name
	 * @param index of the funding account to add the transaction to
	 */
	public void addTransaction(String date, double amount, String type, int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		Expense aExpense = new Expense(amount, date, type, aLab.getFundingAccount(index));
		aLab.getFundingAccount(index).addExpense(aExpense);
	}


	/**
	 * This method will add a transaction to the lab and update the balance of that account.
	 * The transaction can also be tracked in the financial report (view Expenses method)
	 * @param date of the transaction
	 * @param amount of the cost of the transaction by double
	 * @param type of transaction by String
	 * @param fundingAccount target name
	 * @throws InvalidInputException
	 */
	public void addExpense(String fundingAccount, double amount, String date, String type)
			throws InvalidInputException {
		String error = "";

		if (date == null || date.isEmpty()) {
			error += "Please enter a date. ";
		}
		if (type == null || type.isEmpty()) {
			error += "Please enter a transaction type. ";
		}
		if (fundingAccount == null || fundingAccount.isEmpty()) {
			error += "Please enter a funding account name";
		}

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}

		FundingAccount currentFundingAccount;
		try {
			currentFundingAccount = getFundingAccount(fundingAccount);
			Expense aExpense = new Expense(amount, date, type, currentFundingAccount);
			currentFundingAccount.addExpense(aExpense);
			double currentBalance = currentFundingAccount.getBalance();
			currentFundingAccount.setBalance(currentBalance - amount);
		} catch (Exception e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	/**
	 * This method will edit the name of an existing funding account.
	 * @param targetType name of old account
	 * @param newType name of the desired edit
	 * @throws InvalidInputException
	 */
	public void editFundingAccount(String targetType, String newType) throws InvalidInputException {
		String error = "";

		if (targetType == null || targetType.isEmpty()) {
			error += "Please enter the old name for the account. ";
		}
		if (newType == null || newType.isEmpty()) {
			error += "Please enter the new name for the account. ";
		}

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}

		FundingAccount currentFundingAccount = null;
		try {
			currentFundingAccount = getFundingAccount(targetType);
			currentFundingAccount.setType(newType);
		} catch (Exception e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	/**
	 * This method is a getter method to get a specific expense of a funding account
	 * @param index of the funding account in the list
	 * @return
	 */
	public Expense getExpense(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		return aLab.getFundingAccount(index).getExpenses().get(index);
	}

	/**
	 * This method is a getter method to get the wanted Funding Account by name.
	 * @param fundingType name of account
	 * @return the funding account wanted
	 * @throws InvalidInputException
	 */
	public FundingAccount getFundingAccount(String fundingType) throws InvalidInputException {
		String error = "";

		if (fundingType == null || fundingType.isEmpty()) {
			error += "Please enter a name for the account. ";
		}

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}

		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);

		List<FundingAccount> fundings = aLab.getFundingAccounts();
		for (FundingAccount funding : fundings) {
			if (funding.getType().equals(fundingType)) {
				return funding;
			}
		}
		throw new InvalidInputException("Requested account does not exist :( ");
	}

	/**
	 * This method will initiate funding accounts 
	 *
	 * @return if funding accounts already
	 * exists, method will return 1 else return -1
	 */
	public int initiateFundingAccounts() {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		if (!aLab.hasFundingAccounts()) {
			try {
				addFundingAccount("Supply Funds", 0.00);
				addFundingAccount("Equipment Funds", 0.00);
				addFundingAccount("Staff Funds", 0.00);
			} catch (InvalidInputException e) {
				e.printStackTrace();
			}

			return -1;
		}
		return 1;
	}

	/**
	 * This method is used to remove a funding account in the lab.
	 * @param index of the funding account in the list
	 */
	public void removeFundingAccount(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		aLab.getFundingAccount(index).delete();
	}

	/**
	 * This method is used to remove a funding account in the lab.
	 * @param type name of the funding account
	 * @throws InvalidInputException
	 */
	public void removeFundingAccount(String type) throws InvalidInputException {
		String error = "";

		if (type == null || type.isEmpty()) {
			error += "Please enter the name for the account. ";
		}
		if (error.length() > 0){
			throw new InvalidInputException(error);
		}
		FundingAccount currentFundingAccount = null;
		try {
			currentFundingAccount = getFundingAccount(type);
			currentFundingAccount.delete();
		} catch (Exception e) {
			e.printStackTrace();
		}
	}

	/**
	 * This method is to view the balance of a specific funding account
	 * @param index of the funding account in the list
	 * @return balance of the funding account in String type
	 */
	public String viewFundingAccountBalance(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		return String.valueOf(aLab.getFundingAccount(index).getBalance());
	}

	/**
	 * This method will be used to GENERATE A FINANCIAL REPORT (all the expenses) of a
	 * specific funding account.
	 * @param index of the the funding account in the list
	 * @return list of expenses of a specific account
	 */
	public List<Expense> viewFundingAccountExpenses(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		return aLab.getFundingAccount(index).getExpenses();
	}

	/**
	 * This method will be used to GENERATE A FINANCIAL REPORT (all the expenses) of a
	 * specific funding account.
	 * @param fundingType name of the funding account
	 * @return list of expenses of a specific account
	 * @throws InvalidInputException
	 */
	public List<Expense> viewFundingAccountExpenses(String fundingType) throws InvalidInputException {
		String error = "";

		if (fundingType == null || fundingType.isEmpty()) {
			error += "Please enter the name for the account. ";
		}
		if (error.length() > 0){
			throw new InvalidInputException(error);
		}
		FundingAccount currentFundingAccount;
		try {
			currentFundingAccount = getFundingAccount(fundingType);
			return currentFundingAccount.getExpenses();
		} catch (Exception e) {
			throw new InvalidInputException(e.getMessage());
		}
	}

	/**
	 * This method is used to view all the funding accounts of the lab
	 * @return list of funding accounts of the lab
	 * @throws InvalidInputException
	 */
	public List<FundingAccount> viewFundingAccounts() throws InvalidInputException {
		String error = "";

		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		List<FundingAccount> accountsList;
		try {
			accountsList = aLab.getFundingAccounts();
			if (accountsList.isEmpty()) {
				error = "There are no funding accounts to display. ";
			}
		} catch (RuntimeException e) {
			throw new InvalidInputException(e.getMessage());
		}

		if (error.length() > 0) {
			throw new InvalidInputException(error.trim());
		}

		return accountsList;
	}

	/**
	 * This method is used to get the type name of a specific funding account
	 * @param index of the funding account in the list
	 * @return the type name of the funding account in String type
	 */
	public String viewFundingAccountType(int index) {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		return aLab.getFundingAccount(index).getType();

	}

	/**
	 * This method will get the net balance of the lab.
	 * 
	 * @return the net balance
	 */
	public double viewNetBalance() {
		URLMS urlms = URLMSApplication.getURLMS();
		Lab aLab = urlms.getLab(0);
		List<FundingAccount> fundings = aLab.getFundingAccounts();
		double netBalance = 0;
		for (FundingAccount funding : fundings) {
			netBalance += funding.getBalance();
		}
		return netBalance;
	}
}