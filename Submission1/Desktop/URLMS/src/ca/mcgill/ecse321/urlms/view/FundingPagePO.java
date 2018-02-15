package ca.mcgill.ecse321.urlms.view;

import java.awt.BorderLayout;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.FundingController;
import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.FundingAccount;
import ca.mcgill.ecse321.urlms.model.InventoryItem;
import ca.mcgill.ecse321.urlms.model.StaffMember;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.LayoutStyle.ComponentPlacement;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.util.List;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.BoxLayout;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;
import javax.swing.SwingConstants;

public class FundingPagePO extends JFrame {

	private JPanel contentPane;
	JLabel accountListLabel;
	JLabel welcomeToInventoryLabel;
	JLabel feelFreeLabel;
	String error;

	AddFundingAccountPO afapo = new AddFundingAccountPO();
	EditFundingAccountPO efapo = new EditFundingAccountPO();
	TransactionPagePO tppo = new TransactionPagePO();

	public static FundingController controller = new FundingController();
	private JButton addFundingAccbtn;
	private JButton btnViewAccounts;
	private JButton btnRemoveItem;
	private JButton btnTransactions;
	private JButton btnClose;
	private JButton btnSave;

	/**
	 * Create the frame.
	 */
	public FundingPagePO() {
		initComponents();
	}

	private void initComponents() {
		setTitle("Funding");
		setResizable(false);
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 640, 360);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(new BorderLayout(0, 0));

		JPanel panel = new JPanel();
		contentPane.add(panel, BorderLayout.SOUTH);

		addFundingAccbtn = new JButton("Add Account");
		addFundingAccbtn.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				afapo.setVisible(true);
			}
		});

		btnViewAccounts = new JButton("View Accounts");
		btnViewAccounts.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				String previousText;

				try {
					accountListLabel.setText("");
					List<FundingAccount> accountList = controller.viewFundingAccounts();
					String name;
					double balance;
					accountListLabel.setText("<html>");

					for (FundingAccount aAccount : accountList) {
						previousText = accountListLabel.getText();
						name = aAccount.getType();
						balance = aAccount.getBalance();
						accountListLabel.setText(
								previousText + "Account type: " + name + "&nbsp &nbsp &nbsp " + "Account Balance: $"
										+ String.format("%.2f", balance) + "&nbsp &nbsp &nbsp " + " <br/>");
					}

					previousText = accountListLabel.getText();
					accountListLabel.setText(previousText + " <br/>");

					previousText = accountListLabel.getText();
					accountListLabel.setText(previousText + "Net balance of all accounts: $"
							+ String.format("%.2f", controller.viewNetBalance()));
					previousText = accountListLabel.getText();
					accountListLabel.setText(previousText + "</html>");
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				}

				refreshData();
			}
		});
		panel.add(btnViewAccounts);
		panel.add(addFundingAccbtn);

		btnRemoveItem = new JButton("Edit Account");
		btnRemoveItem.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				efapo.setVisible(true);
			}
		});
		panel.add(btnRemoveItem);

		btnTransactions = new JButton("Transactions");
		btnTransactions.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				tppo.setVisible(true);

			}
		});
		panel.add(btnTransactions);

		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		btnSave = new JButton("Save");
		btnSave.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				controller.save();
				SavePO spo = new SavePO();
				spo.setVisible(true);
			}
		});
		panel.add(btnSave);
		panel.add(btnClose);

		JScrollPane scrollPane = new JScrollPane();
		contentPane.add(scrollPane, BorderLayout.CENTER);

		accountListLabel = new JLabel("");
		accountListLabel.setHorizontalAlignment(SwingConstants.CENTER);
		scrollPane.setViewportView(accountListLabel);

		feelFreeLabel = new JLabel("Feel free to do stuff with the funding.");
		feelFreeLabel.setHorizontalAlignment(SwingConstants.CENTER);
		scrollPane.setColumnHeaderView(feelFreeLabel);

		JPanel panel_1 = new JPanel();
		contentPane.add(panel_1, BorderLayout.NORTH);

		welcomeToInventoryLabel = new JLabel("Welcome to Funding. There's a lot of funds.");
		panel_1.add(welcomeToInventoryLabel);
	}

	private void refreshData() {
		if (error.length() > 0) {
			feelFreeLabel.setText(error);
		} else {
			feelFreeLabel.setText("Here you go, the list of funding accounts and some details about them. ");
		}
	}

	public void close() {
		this.setVisible(false);
		this.dispose();
	}
}
