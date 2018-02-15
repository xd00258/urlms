package ca.mcgill.ecse321.urlms.view;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.FundingController;
import ca.mcgill.ecse321.urlms.controller.InvalidInputException;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JTextField;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JLabel;
import javax.swing.JScrollPane;

public class AddFundingAccountPO extends JFrame {

	private JPanel contentPane;
	public static FundingController controller = new FundingController();
	private JTextField txtAccountType;
	private JTextField txtBalance;
	private String error;
	private JButton btnClose;
	private JScrollPane scrollPane;
	private JLabel lblError;

	/**
	 * Create the frame.
	 */
	public AddFundingAccountPO() {
		setResizable(false);
		setAlwaysOnTop(true);
		initComponents();
	}
	
	private void initComponents(){
		setTitle("Add Funding Account");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 568, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtAccountType = new JTextField();
		txtAccountType.setColumns(10);
		
		txtBalance = new JTextField();
		txtBalance.setColumns(10);
		
		JButton btnAdd = new JButton("Add");
		btnAdd.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				try {
					String accountType = txtAccountType.getText();
					double balance = Double.valueOf(txtBalance.getText());
					controller.addFundingAccount(accountType, balance);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (NumberFormatException e1) {
					error += "Please enter a valid initial balance. ";
				} catch (RuntimeException e1) {
					error += "stuff happened. ";
				}
				refreshData();
			}
		});
		
		JLabel lblAccountName = new JLabel("Account Type (Case sensitive):");
		
		JLabel lblBalance = new JLabel("Initial Balance (CAD):");
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		scrollPane = new JScrollPane();
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
					.addContainerGap(44, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addComponent(btnAdd)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(btnClose)
							.addGap(200))
						.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
							.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING)
								.addComponent(lblBalance)
								.addComponent(lblAccountName))
							.addGap(18)
							.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING, false)
								.addComponent(txtBalance)
								.addComponent(txtAccountType, GroupLayout.PREFERRED_SIZE, 239, GroupLayout.PREFERRED_SIZE))
							.addGap(33))))
				.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
					.addGap(27)
					.addComponent(scrollPane)
					.addGap(17))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(36)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtAccountType, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblAccountName))
					.addPreferredGap(ComponentPlacement.UNRELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtBalance, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblBalance))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 57, GroupLayout.PREFERRED_SIZE)
					.addPreferredGap(ComponentPlacement.RELATED, 21, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(btnAdd)
						.addComponent(btnClose))
					.addGap(50))
		);
		
		lblError = new JLabel("You can add some accounts here.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Account successfully created.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
