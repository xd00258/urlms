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

public class AddExpensePO extends JFrame {

	private JPanel contentPane;
	public static FundingController controller = new FundingController();
	private JTextField txtAccountType;
	private JTextField txtExpenseAmount;
	private String error;
	private JButton btnClose;
	private JScrollPane scrollPane;
	private JLabel lblError;
	private JTextField txtExpenseDate;
	private JTextField txtExpenseType;
	private JLabel lblExpenseDate;
	private JLabel lblExpenseType;

	/**
	 * Create the frame.
	 */
	public AddExpensePO() {
		setType(Type.POPUP);
		setResizable(false);
		setAlwaysOnTop(true);
		initComponents();
	}
	
	private void initComponents(){
		setTitle("Add Expense");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 568, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtAccountType = new JTextField();
		txtAccountType.setColumns(10);
		
		txtExpenseAmount = new JTextField();
		txtExpenseAmount.setColumns(10);
		
		JButton btnAdd = new JButton("Add");
		btnAdd.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				try {
					String accountType = txtAccountType.getText();
					double amount = Double.valueOf(txtExpenseAmount.getText());
					String date = txtExpenseDate.getText();
					String expenseType = txtExpenseType.getText();
					controller.addExpense(accountType, amount, date, expenseType);
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (NumberFormatException e1) {
					error += "Please enter a valid expense amount. ";
				} catch (RuntimeException e1) {
					error += "stuff happened. ";
				}
				refreshData();
			}
		});
		
		JLabel lblAccountType = new JLabel("Account Type (Case sensitive):");
		
		JLabel lblExpenseAmount = new JLabel("Expense Amount (CAD):");
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		scrollPane = new JScrollPane();
		
		txtExpenseDate = new JTextField();
		txtExpenseDate.setColumns(10);
		
		txtExpenseType = new JTextField();
		txtExpenseType.setColumns(10);
		
		lblExpenseDate = new JLabel("Expense Date:");
		
		lblExpenseType = new JLabel("Expense Type:");
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.TRAILING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addContainerGap(52, Short.MAX_VALUE)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING)
						.addComponent(lblExpenseAmount)
						.addComponent(lblAccountType)
						.addComponent(lblExpenseDate)
						.addComponent(lblExpenseType))
					.addGap(18)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING, false)
						.addComponent(txtExpenseAmount)
						.addComponent(txtAccountType, Alignment.TRAILING, GroupLayout.DEFAULT_SIZE, 239, Short.MAX_VALUE)
						.addComponent(txtExpenseDate)
						.addComponent(txtExpenseType))
					.addGap(25))
				.addGroup(gl_contentPane.createSequentialGroup()
					.addContainerGap(211, Short.MAX_VALUE)
					.addComponent(btnAdd)
					.addPreferredGap(ComponentPlacement.RELATED)
					.addComponent(btnClose)
					.addGap(200))
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(27)
					.addComponent(scrollPane)
					.addGap(17))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.TRAILING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addContainerGap()
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtAccountType, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblAccountType))
					.addPreferredGap(ComponentPlacement.UNRELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtExpenseAmount, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblExpenseAmount))
					.addPreferredGap(ComponentPlacement.UNRELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtExpenseDate, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblExpenseDate))
					.addPreferredGap(ComponentPlacement.UNRELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtExpenseType, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblExpenseType))
					.addGap(18)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 38, GroupLayout.PREFERRED_SIZE)
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(btnAdd)
						.addComponent(btnClose))
					.addGap(34))
		);
		
		lblError = new JLabel("You can add some expenses to an account here.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Expense successfully added.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
